<?php

namespace App\Livewire\Board;

use App\Models\Client;
use App\Models\Task;
use App\Models\User;
use App\Notifications\AppNotification;
// 
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class Index extends Component
{
    public $tasks = [];
    public $newTask;
    public $newTaskDescription;
    public $board;
    public $selectedTask = null;

    public $assignedTo = null;
    public $users;
    public $priority = 'low';
    public $dueDate = null;

    // Separate modal control variables
    public $showAddTaskModal = false;
    public $showTaskDetailsModal = false;

    // Filter properties
    public $search = '';
    public $priorityFilter = 'all';
    public $statusFilter = 'all';
    public $assignableUsers = [];

    protected $rules = [
        'newTask' => 'required|min:3|max:255',
        'newTaskDescription' => 'nullable|max:1000',
        'assignedTo' => 'nullable|exists:users,id',
    ];

    public function mount(Client $client)
    {
        $this->board = $client->board;
        $this->users = User::where('prueba', 'admin')->get();
        $this->loadTasks();
        $this->loadAssignableUsers();
    }

    public function loadTasks()
    {
        $query = $this->board->tasks()
            ->with(['assignee', 'creator'])
            ->orderBy('status')
            ->orderBy('order');

        // Aplicar filtros si existen
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $tasks = $query->get();

        $this->tasks = [
            'todo' => $tasks->where('status', 'todo')->values()->toArray(),
            'in_progress' => $tasks->where('status', 'in_progress')->values()->toArray(),
            'done' => $tasks->where('status', 'done')->values()->toArray()
        ];
    }

    public function openAddTaskModal()
    {
        $this->resetErrorBag();
        $this->reset(['newTask', 'newTaskDescription', 'priority', 'dueDate', 'assignedTo']);
        $this->showAddTaskModal = true;
    }

    public function closeAddTaskModal()
    {
        $this->showAddTaskModal = false;
    }

    public function closeTaskDetailsModal()
    {
        $this->showTaskDetailsModal = false;
        $this->selectedTask = null;
    }

    public function addTask()
    {
        $this->validate();

        // Ensure priority has a default value if not set
        if (empty($this->priority)) {
            $this->priority = 'low';
        }

        // Create the task in the database
        $task = Task::create([
            'board_id' => $this->board->id,
            'name' => $this->newTask,
            'description' => $this->newTaskDescription,
            'status' => 'todo',
            'order' => count($this->tasks['todo']) + 1,
            'assigned_to' => $this->assignedTo,
            'created_by' => Auth::id(),
            'priority' => $this->priority,
            'due_date' => $this->dueDate
        ]);

        // Send notification
        $notificationData = [
            'type' => 'task',
            'titulo' => $task->name,
            'task_id' => $task->id,
            'from_user' => Auth::user()->name,
            'board_id' => $this->board->id,
        ];

        Notification::send(User::find($this->assignedTo), new AppNotification('task', $notificationData));

        // Send email
        try {
            $assignee = User::find($this->assignedTo);

            Mail::send('mail.task_assigned', [
                'task' => $task,
                'board' => $this->board
            ], function ($message) use ($task, $assignee) {
                $message->to($assignee->email)
                    ->subject('Task Assigned: ' . $task->name);
            });
        } catch (\Exception $e) {
            Log::error('Error sending task assignment email: ' . $e->getMessage());
        }

        // Reset and reload
        $this->loadTasks();
        $this->closeAddTaskModal();
        $this->reset(['newTask', 'newTaskDescription', 'priority', 'assignedTo', 'dueDate']);
        $this->dispatch('task-added');
    }

    public function getProgressPercentageProperty()
    {
        $totalTasks = count($this->tasks['todo'] ?? [])
            + count($this->tasks['in_progress'] ?? [])
            + count($this->tasks['done'] ?? []);

        $completedTasks = count($this->tasks['done'] ?? []);

        return $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
    }

    public function removeTask($taskId)
    {
        $task = Task::find($taskId);

        if ($task && $task->board_id == $this->board->id) {
            $task->delete();
            $this->loadTasks();
            $this->closeTaskDetailsModal();
            $this->dispatch('task-removed');
        }
    }

    public function showTaskDetails($taskId)
    {
        $task = Task::with(['assignee', 'creator'])
            ->where('board_id', $this->board->id)
            ->find($taskId);

        if ($task) {
            $this->selectedTask = $task->toArray();
            $this->showTaskDetailsModal = true;
        }
    }

    public function changeTaskStatus($taskId, $newStatus)
    {
        $task = Task::where('board_id', $this->board->id)->find($taskId);

        if ($task) {
            $task->update(['status' => $newStatus]);
            $this->loadTasks();

            // If we're viewing the task details, close the modal if status is changed to done
            if ($this->showTaskDetailsModal && $newStatus === 'done') {
                $this->closeTaskDetailsModal();
            }
        }
    }

    public function updateTaskOrder($orderedIds, $status)
    {
        Task::where('board_id', $this->board->id)
            ->whereIn('id', $orderedIds)
            ->get()
            ->each(function ($task) use ($orderedIds, $status) {
                $task->update([
                    'order' => array_search($task->id, $orderedIds) + 1,
                    'status' => $status
                ]);
            });

        $this->loadTasks();
    }

    public function moveTask($taskId, $newStatus)
    {
        $task = Task::where('board_id', $this->board->id)->find($taskId);

        if ($task) {
            $task->update([
                'status' => $newStatus,
                'order' => Task::where('board_id', $this->board->id)
                    ->where('status', $newStatus)
                    ->count() + 1
            ]);

            $this->loadTasks();
        }
    }

    public function updated()
    {
        // Recargar tareas cuando cambian los filtros
        $this->loadTasks();
    }

    public function loadAssignableUsers()
    {
        $this->assignableUsers = User::get();
    }

    public function render()
    {
        return view('livewire.board.index', [
            'todoTasks' => $this->tasks['todo'] ?? [],
            'inProgressTasks' => $this->tasks['in_progress'] ?? [],
            'doneTasks' => $this->tasks['done'] ?? [],
            'progressPercentage' => $this->progressPercentage,
        ]);
    }
}
