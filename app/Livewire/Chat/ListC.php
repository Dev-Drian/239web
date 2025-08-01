<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ListC extends Component
{
    public $selectedChatType; // 'private' o 'group'
    public $selectedId; // chat_id

    // Propiedades para la creación de chats
    public $chatType = 'private';
    public $userSearch = '';
    public $searchResults = [];
    public $selectedUsers = [];
    public $groupName = '';
    public $showModal = false;

    // Nuevas propiedades para el modal
    public $modalChatType = 'private'; // Nueva variable para el modal
    public $modalUserSearch = '';
    public $modalSelectedUsers = [];
    public $modalGroupName = '';

    public function getListeners()
    {
        return [
            "echo-private:user." . Auth::id() . ",.message.sent" => 'handleNewMessage',
        ];
    }

    public function handleNewMessage($event)
    {
        // dd($event);
        // Forzar actualización de la lista de chats
        $this->render();

        // Si es el chat seleccionado, marcar como leído
        if ($this->selectedId == $event['chatId']) {
            $this->dispatch('markAsRead', $event['chatId']);
        }
    }

    // Métodos existentes
    public function selectChat($chatType, $chatId)
    {

        $this->selectedChatType = $chatType;
        $this->selectedId = $chatId;
        $this->dispatch('chatChanged');
    }

    public function checkForUpdates()
    {
        // Solo marca para rerender si hay cambios recientes
        $this->render();
    }

    // Nuevos métodos para manejar el modal
    public function openModal()
    {
        $this->resetModalForm();
        $this->showModal = true;
        $this->updatedModalUserSearch(); // Cargar usuarios iniciales
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    private function resetModalForm()
    {
        $this->modalChatType = 'private';
        $this->modalUserSearch = '';
        $this->modalSelectedUsers = [];
        $this->modalGroupName = '';
        $this->resetErrorBag();
    }

    public function updatedModalUserSearch()
    {
        $query = User::where('id', '!=', Auth::id());

        if (strlen($this->modalUserSearch) >= 2) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->modalUserSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->modalUserSearch . '%');
            });
        }

        $this->searchResults = $query->limit(10)->get();
    }

    public function selectModalUser($userId)
    {
        if ($this->modalChatType === 'private') {
            // Para chat privado, solo mantener un usuario seleccionado
            $this->modalSelectedUsers = [$userId];
        } else {
            // Para grupo, permitir múltiples selecciones
            if (!in_array($userId, $this->modalSelectedUsers)) {
                $this->modalSelectedUsers[] = $userId;
            } else {
                $this->modalSelectedUsers = array_values(array_filter(
                    $this->modalSelectedUsers,
                    fn($id) => $id != $userId
                ));
            }
        }
    }

    public function removeUser($userId)
    {
        $this->modalSelectedUsers = array_values(array_filter($this->modalSelectedUsers, function ($id) use ($userId) {
            return $id != $userId;
        }));
    }

    public function setChatType($type)
    {
        $this->chatType = $type;
    }

    // Métodos para la búsqueda y selección de usuarios
    public function updatedUserSearch()
    {
        // Siempre cargar resultados, incluso cuando el campo está vacío
        $query = User::where('id', '!=', Auth::id());

        if (strlen($this->userSearch) >= 2) {
            // Filtrar por término de búsqueda si hay texto
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->userSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->userSearch . '%');
            });
        }

        $this->searchResults = $query->limit(10)->get();
    }

    public function selectUser($userId)
    {
        if (!in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers[] = $userId;

            // Si es chat privado y se selecciona un usuario, verificar si ya existe
            if ($this->chatType === 'private') {
                // Limpiar cualquier otro usuario seleccionado previamente
                $this->selectedUsers = [$userId];

                // Verificar si ya existe un chat con este usuario
                $existingChat = $this->findExistingPrivateChat($userId);
                if ($existingChat) {
                    $this->selectChat('private', $existingChat->id);
                    $this->closeModal(); // Cerrar modal solo si ya existe el chat
                    return;
                }
            }
        } else {
            $this->removeUser($userId);
        }
    }

    public function createChat()
    {
        $this->validate([
            'modalSelectedUsers' => 'required|array|min:1',
            'modalSelectedUsers.*' => 'exists:users,id',
            'modalGroupName' => 'required_if:modalChatType,group|string|max:255|nullable',
        ]);

        // Verificar si es chat privado y ya existe
        if ($this->modalChatType === 'private' && count($this->modalSelectedUsers) === 1) {
            $existingChat = $this->findExistingPrivateChat($this->modalSelectedUsers[0]);

            if ($existingChat) {
                $this->selectChat('private', $existingChat->id);
                $this->closeModal();
                $this->dispatch('notify', 'Chat already exists');
                return;
            }
        }

        // Crear el chat dentro de una transacción
        DB::transaction(function () {
            $chat = Chat::create([
                'type' => $this->modalChatType,
                'name' => $this->modalChatType === 'group' ? $this->modalGroupName : null,
                'created_by' => Auth::id(),
            ]);

            // Agregar usuarios (usuario actual + seleccionados)
            $usersToAdd = array_merge([Auth::id()], $this->modalSelectedUsers);
            $chat->users()->attach($usersToAdd);

            // Seleccionar el nuevo 
            $this->selectChat($this->modalChatType, $chat->id);

            // Notificar a los usuarios (si estás usando broadcasting)
            if ($this->modalChatType === 'private') {
                $this->dispatch('privateChatCreated', $chat->id);
            } else {
                $this->dispatch('groupChatCreated', $chat->id);
            }
        });

        $this->closeModal();
        $this->dispatch('notify', 'Chat created successfully');
    }

    private function findExistingPrivateChat($otherUserId)
    {
        $userId = Auth::id();

        return Chat::where('type', 'private')
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereHas('users', function ($query) use ($otherUserId) {
                $query->where('user_id', $otherUserId);
            })
            ->where(function ($query) {
                $query->selectRaw('count(*)')
                    ->from('chat_user')
                    ->whereColumn('chat_user.chat_id', 'chats.id');
            }, '=', 2)
            ->first();
    }

    private function resetForm()
    {
        $this->chatType = 'private';
        $this->userSearch = '';
        $this->searchResults = [];
        $this->selectedUsers = [];
        $this->groupName = '';
        $this->resetErrorBag();
    }

    public function getSelectedUsers()
    {
        return User::whereIn('id', $this->modalSelectedUsers)->get();
    }

    public function render()
    {
        $userId = Auth::id();

        $chats = Chat::with([
            'users' => function ($query) use ($userId) {
                $query->where('user_id', '!=', $userId); // Para chats privados
            },
            'messages' => function ($query) {
                $query->latest()->limit(1)->with('sender');
            }
        ])
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->withCount(['messages as unread_messages_count' => function ($query) use ($userId) {
                $query->whereDoesntHave('reads', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('sender_id', '!=', $userId);
            }])
            ->get()
            ->map(function ($chat) use ($userId) {
                if ($chat->type === 'private') {
                    $chat->other_user = $chat->users->first();
                }

                $lastMessage = $chat->messages->first();
                $chat->last_message = $lastMessage?->message ?? null;
                $chat->last_message_time = $lastMessage?->created_at ?? null;
                $chat->last_message_sender = $lastMessage?->sender?->name ?? null;

                return $chat;
            })
            ->sortByDesc(function ($chat) {
                return $chat->last_message_time ?? $chat->created_at;
            });

        $privateChats = $chats->where('type', 'private');
        $groupChats = $chats->where('type', 'group');

        // Siempre mantener actualizados los resultados de búsqueda
        if (empty($this->searchResults)) {
            $this->updatedUserSearch();
        }

        return view('livewire.chat.list-c', [
            'privateChats' => $privateChats,
            'groupChats' => $groupChats,
        ]);
    }
}
