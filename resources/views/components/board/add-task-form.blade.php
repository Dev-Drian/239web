<div
    class="mb-8 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 p-5 border border-gray-200">
    <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add new task
    </h2>
    <div class="space-y-4">
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
                    {{-- @forelse($assignableUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @empty
                    @endforelse --}}
                </select>
            </div>
        </div>

        <!-- Add Task Button -->
        <button wire:click="addTask"
            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-3 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg w-full sm:w-auto"
            aria-label="Add new task">
            <span class="flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Add Task
            </span>
        </button>
    </div>
</div>
