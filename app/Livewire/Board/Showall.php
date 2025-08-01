<?php

namespace App\Livewire\Board;

use App\Models\Client;
use App\Models\Task;
use App\Models\User;
use App\Notifications\AppNotification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Showall extends Component
{
    public $tasks = [];
    public $newTask;
    public $newTaskDescription;
    public $selectedTask = null;
    public $assignedTo = null;
    public $users;
    public $priority = 'low';
    public $dueDate = null;
    public $search = '';
    public $statusFilter = 'all';
    public $priorityFilter = 'all';
    public $assignableUsers = [];

    // Modal control variables
    public $showAddTaskModal = false;
    public $showTaskModal = false;

    protected $rules = [
        'newTask' => 'required|min:3|max:255',
        'newTaskDescription' => 'nullable|max:1000',
        'assignedTo' => 'nullable|exists:users,id',
        'priority' => 'required|in:low,medium,high,critical',
    ];

    public function mount()
    {
        $this->loadTasks();
        $this->loadAssignableUsers();
    }

    public function loadTasks()
    {
        $query = Task::with(['assignee', 'creator'])
            ->orderBy('status')
            ->orderBy('order');

        // Apply filters if they exist
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->priorityFilter !== 'all') {
            $query->where('priority', $this->priorityFilter);
        }

        if ($this->assignedTo) {
            $query->where('assigned_to', $this->assignedTo);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $this->tasks = $query->get()->map(function ($task) {
            return [
                'id' => $task->id,
                'name' => $task->name,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'created_at' => $task->created_at,
                'client' => $task->board->client->name,
                'due_date' => $task->due_date,
                'assignee' => $task->assignee ? [
                    'id' => $task->assignee->id,
                    'name' => $task->assignee->name
                ] : null,
                'creator' => $task->creator ? [
                    'id' => $task->creator->id,
                    'name' => $task->creator->name
                ] : null
            ];
        })->toArray();
    }

    public function loadAssignableUsers()
    {
        $this->assignableUsers = User::all();
    }

    public function openAddTaskModal()
    {
        $this->resetErrorBag();
        $this->reset(['newTask', 'newTaskDescription', 'priority', 'dueDate', 'assignedTo']);
        $this->showAddTaskModal = true;
        $this->showTaskModal = false;
    }

    public function closeTaskDetailsModal()
    {
        $this->showTaskModal = false;
        $this->selectedTask = null;
    }

    public function closeAddTaskModal()
    {
        $this->showAddTaskModal = false;
        $this->reset(['newTask', 'newTaskDescription', 'priority', 'dueDate', 'assignedTo']);
        $this->resetErrorBag();
    }

    public function closeTaskModal()
    {
        $this->showTaskModal = false;
        $this->showAddTaskModal = false;
        $this->selectedTask = null;
        $this->reset(['newTask', 'newTaskDescription', 'priority', 'dueDate', 'assignedTo']);
        $this->resetErrorBag();
    }

    public function addTask()
    {
        $this->validate();

        // Create the task in the database
        $task = Task::create([
            'name' => $this->newTask,
            'description' => $this->newTaskDescription,
            'status' => 'todo',
            'order' => Task::where('status', 'todo')->count() + 1,
            'assigned_to' => $this->assignedTo,
            'created_by' => Auth::id(),
            'priority' => $this->priority,
            'due_date' => $this->dueDate
        ]);
        
        $this->loadTasks();
        $this->closeTaskModal();
        $this->reset(['newTask', 'newTaskDescription', 'priority', 'assignedTo', 'dueDate']);
        $this->dispatch('task-added');
        try {
            Mail::send('mail.index', [], function ($message) use ($task) {
                $message->to($task->assignee->email)
                        ->subject('Prueba');
            });
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function showTaskDetails($taskId)
    {
        $task = Task::with(['assignee', 'creator'])
            ->find($taskId);

        if ($task) {
            $this->selectedTask = $task->toArray();
            $this->showTaskModal = true;
            $this->showAddTaskModal = false;
        }
    }

    public function removeTask($taskId)
    {
        $task = Task::find($taskId);

        if ($task) {
            $task->delete();
            $this->loadTasks();
            $this->closeTaskModal();
            $this->dispatch('task-removed');
        }
    }

    public function changeTaskStatus($taskId, $newStatus)
    {
        try {
            $task = Task::findOrFail($taskId);

            $task->update([
                'status' => $newStatus,
                'updated_at' => now()
            ]);

            // Recargar las tareas inmediatamente
            $this->loadTasks();

            // Cerrar el modal si la tarea se completó
            if ($newStatus === 'done' && $this->showTaskModal) {
                $this->closeTaskModal();
            }

            // Despachar evento para actualizar la UI
            $this->dispatch('task-status-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating task status: ' . $e->getMessage());
        }
    }

    public function updated()
    {
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.board.showall', [
            'allTasks' => $this->tasks,
        ]);
    }
}
