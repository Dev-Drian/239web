<div class="fixed inset-0 backdrop-filter backdrop-blur-md flex items-center justify-center p-4 z-50 transition-opacity duration-300"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-transform duration-300 scale-95"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         @click.away="$wire.closeTaskDetailsModal()">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-semibold text-gray-900 transition-opacity duration-300"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">{{ $task['name'] }}</h3>
                <button wire:click="closeTaskDetailsModal"
                        class="text-gray-500 hover:text-gray-700 transform hover:scale-110"
                        aria-label="Close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-4 transition-opacity duration-300"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Description</h4>
                <p class="mt-1 text-gray-700 whitespace-pre-wrap rounded-md border border-gray-200 p-3">
                    {{ $task['description'] ?? 'No description provided' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 transition-opacity duration-300"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div>
                    <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Status</h4>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                            {{ str_replace('_', ' ', $task['status']) }}
                        </span>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Priority</h4>
                    <div class="mt-1">
                        @if(isset($task['priority']))
                            @switch($task['priority'])
                                @case('high')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-red-500 text-white border border-red-500">
                                        High Priority
                                    </span>
                                    @break
                                @case('medium')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-yellow-500 text-white border border-yellow-500">
                                        Medium Priority
                                    </span>
                                    @break
                                @case('low')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-500 text-white border border-green-500">
                                        Low Priority
                                    </span>
                                    @break
                                @case('critical')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-purple-500 text-white border border-purple-500">
                                        Critical
                                    </span>
                                    @break
                            @endswitch
                        @else
                            <span class="text-gray-500">Not set</span>
                        @endif
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Created</h4>
                    <p class="mt-1 text-gray-700">
                        {{ \Carbon\Carbon::parse($task['created_at'])->format('M j, Y g:i A') }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-2">Due Date</h4>
                    <p class="mt-1 text-gray-700">
                        @if(isset($task['due_date']))
                            {{ \Carbon\Carbon::parse($task['due_date'])->format('M j, Y g:i A') }}
                            @if(\Carbon\Carbon::parse($task['due_date'])->isPast())
                                <span class="ml-2 bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full">Overdue</span>
                            @endif
                        @else
                            No due date
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-2 transition-opacity duration-300"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <button wire:click="changeTaskStatus('{{ $task['id'] }}', 'todo')"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transform hover:scale-105"
                        {{ $task['status'] == 'todo' ? 'disabled' : '' }}>
                    To Do
                </button>
                {{-- <button wire:click="changeTaskStatus('{{ $task['id'] }}', 'in_progress')"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transform hover:scale-105"
                        {{ $task['status'] == 'in_progress' ? 'disabled' : '' }}>
                    In Progress
                </button> --}}
                <button wire:click="changeTaskStatus('{{ $task['id'] }}', 'done')"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transform hover:scale-105"
                        {{ $task['status'] == 'done' ? 'disabled' : '' }}>
                    Done
                </button>
                <button wire:click="removeTask('{{ $task['id'] }}')"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transform hover:scale-105">
                    Delete Task
                </button>
            </div>
        </div>
    </div>
</div>