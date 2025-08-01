    <div>
        <!-- Notification -->
    @if (session()->has('message'))
        <x-board.notification :message="session('message')" />
    @endif

        <div class="max-w-7xl mx-auto p-4 bg-white rounded-lg shadow-md mt-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Task Board</h1>
            </div>  

            <!-- Filters -->
            <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <input type="text" wire:model.live="search" placeholder="Search tasks..."
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <select wire:model.live="statusFilter"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="all">All Status</option>
                        <option value="todo">To Do</option>
                        <option value="done">Completed</option>
                    </select>
                </div>
                <div>
                    <select wire:model.live="priorityFilter"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="all">All Priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
                <div>
                    <select wire:model.live="assignedTo"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">All Users</option>
                        @foreach ($assignableUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                </div>
            </div>

            <!-- Main Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Task
                            </th>
                            <th scope="col"
                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Priority
                            </th>
                            <th scope="col"
                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Due Date
                            </th>
                            <th scope="col"
                                class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Assigned
                            </th>
                            <th scope="col"
                                class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($allTasks as $task)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2">
                                    <div class="text-sm font-medium text-gray-900 flex items-center">
                                        {{ $task['name'] }}


                                        @if ($task['client'])
                                            <span class="ml-2 px-2 text-xs rounded-full bg-blue-50 text-blue-600">
                                                {{ $task['client'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs">
                                        {{ Str::limit($task['description'] ?? '', 30) }}
        </div>
                                </td>
                                <td class="px-3 py-2">
                                    <select wire:change="changeTaskStatus('{{ $task['id'] }}', $event.target.value)"
                                        wire:loading.attr="disabled"
                                        class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs transition-colors duration-200"
                                        :class="{
                                            'bg-green-50': $task['status'] === 'done',
                                            'bg-blue-50': $task['status'] === 'todo'
                                        }">
                                        <option value="todo" {{ $task['status'] == 'todo' ? 'selected' : '' }}>To Do
                                        </option>
                                        <option value="done" {{ $task['status'] == 'done' ? 'selected' : '' }}>Done
                                        </option>
                                    </select>
                                </td>
                                <td class="px-3 py-2">
                                    @if (isset($task['priority']))
                                        @switch($task['priority'])
                                            @case('high')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    High
                                                </span>
                                            @break

                                            @case('medium')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Medium
                                                </span>
                                            @break

                                            @case('low')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Low
                                                </span>
                                            @break

                                            @case('critical')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    Critical
                                                </span>
                                            @break
                                        @endswitch
                                    @endif
                                </td>
                                
                                <td class="px-3 py-2 text-xs text-gray-500 whitespace-nowrap">
                                    @if (isset($task['due_date']))
                                        <div class="flex items-center">
                                            <span class="{{ \Carbon\Carbon::parse($task['due_date'])->isPast() && $task['status'] !== 'done' ? 'text-red-600 font-semibold' : '' }}">
                                                {{ \Carbon\Carbon::parse($task['due_date'])->format('m/d/Y') }}
                                            </span>
                                            
                                            @if (\Carbon\Carbon::parse($task['due_date'])->isPast() && $task['status'] !== 'done')
                                                <span class="ml-1 relative group">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    <span class="absolute hidden group-hover:block bg-gray-800 text-white text-xs rounded px-2 py-1 -bottom-6 left-1/2 transform -translate-x-1/2">
                                                        @php
                                                            $dueDate = \Carbon\Carbon::parse($task['due_date']);
                                                            $now = \Carbon\Carbon::now();
                                                            $diff = $dueDate->diff($now);
                                                            echo $diff->y > 0 ? $diff->y.'y ' : '';
                                                            echo $diff->m > 0 ? $diff->m.'m ' : '';
                                                            echo $diff->d.'d overdue';
                                                        @endphp
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="px-3 py-2 text-xs text-gray-500">
                                    {{ $task['assignee']['name'] ?? '-' }}
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button wire:click="showTaskDetails('{{ $task['id'] }}')"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button wire:click="removeTask('{{ $task['id'] }}')"
                                            class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-4 text-sm text-gray-500 text-center">
                                        No tasks match the filters
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        </div>

            <!-- Task Details Modal -->
            @if ($showTaskModal && $selectedTask)
            <x-board.task-modal :task="$selectedTask" />
        @endif

    </div>
