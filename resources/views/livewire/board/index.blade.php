<div>
    <!-- Notificación -->
    @if (session()->has('message'))
        <x-board.notification :message="session('message')" />
    @endif

    <div class="max-w-6xl mx-auto p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">Task Board</h1>

        <!-- Barra de progreso -->
        <x-board.progress-bar :percentage="$progressPercentage" />

        <!-- Filtros y búsqueda -->
        <button wire:click="openAddTaskModal"
            class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Add New Task
        </button>

        <!-- Modal para agregar tareas -->
        @if ($showAddTaskModal)
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                    <!-- Contenido del modal -->
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <!-- Encabezado -->
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add new task
                                </h3>
                                <button wire:click="closeAddTaskModal" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Formulario -->
                            <div class="space-y-4 mt-4">
                                <!-- Task Title -->
                                <div class="transform transition-all duration-200 hover:scale-[1.01]">
                                    <input type="text" wire:model="newTask" placeholder="Task title"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-gray-400">
                                    @error('newTask')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Task Description -->
                                <div class="transform transition-all duration-200 hover:scale-[1.01]">
                                    <textarea wire:model="newTaskDescription" placeholder="Description (optional)"
                                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all h-24 placeholder-gray-400"></textarea>
                                    @error('newTaskDescription')
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Task Details Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Priority -->
                                    <div class="transform transition-all duration-200 hover:scale-[1.01]">
                                        <select wire:model="priority"
                                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                            <option value="low">Low Priority</option>
                                            <option value="medium" selected>Medium Priority</option>
                                            <option value="high">High Priority</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>

                                    <!-- Due Date -->
                                    <div class="transform transition-all duration-200 hover:scale-[1.01]">
                                        <input type="datetime-local" wire:model="dueDate"
                                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                    </div>

                                    <!-- Assignee -->
                                    <div class="transform transition-all duration-200 hover:scale-[1.01] md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Assign to</label>
                                        <select wire:model="assignedTo"
                                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                            <option value="">Unassigned</option>
                                            @foreach($assignableUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie del modal -->
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="addTask" type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                                <span class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Add Task
                                </span>
                            </button>
                            <button wire:click="closeAddTaskModal" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Columnas del tablero -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-board.task-column title="To Do" status="todo" color="blue" :tasks="$todoTasks"
                icon="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
{{-- 
            <x-board.task-column title="In Progress" status="in_progress" color="yellow" :tasks="$inProgressTasks"
                icon="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" /> --}}

            <x-board.task-column title="Completed" status="done" color="green" :tasks="$doneTasks"
                icon="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
        </div>
    </div>

    <!-- Modal de detalles -->
    @if ($showTaskDetailsModal && $selectedTask)
        <x-board.task-modal :task="$selectedTask" />
    @endif

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.hook('message.processed', () => {
                    document.querySelectorAll('[x-data]').forEach(el => {
                        Alpine.initTree(el);
                    });
                });
            });
        </script>
    @endpush
</div>