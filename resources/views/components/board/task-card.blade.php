@php
    // Determine the background color class based on priority
    $priorityColorClass = 'bg-gray-100 text-gray-700'; // Default color

    if (isset($task['priority'])) {
        switch($task['priority']) {
            case 'high':
                $priorityColorClass = 'bg-red-100 text-red-700';
                break;
            case 'medium':
                $priorityColorClass = 'bg-yellow-100 text-yellow-700';
                break;
            case 'low':
                $priorityColorClass = 'bg-green-100 text-green-700';
                break;
            case 'critical':
                $priorityColorClass = 'bg-purple-100 text-purple-700';
                break;
        }
    }
@endphp

<div wire:key="{{ $status }}-task-{{ $task['id'] }}" data-id="{{ $task['id'] }}"
     class="task-card rounded-lg shadow-sm border border-gray-200 cursor-move group hover:shadow-md transition-all duration-200 flex border-l-4 border-{{ $color }}-500 mb-4"
     x-on:click.stop="$wire.showTaskDetails('{{ $task['id'] }}')"
     draggable="true">

    <div class="p-5 flex-1">
        <!-- Header with title and delete button -->
        <div class="flex justify-between items-start mb-3">
            <h3 class="font-semibold text-gray-800 text-lg">{{ $task['name'] }}</h3>
            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button wire:click.stop="removeTask('{{ $task['id'] }}')"
                        class="p-1.5 rounded-md bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                        x-tooltip="'Remove Task'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                              clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Description -->
        @if (!empty($task['description']))
            <p class="text-gray-600 text-sm line-clamp-2 break-words overflow-hidden mb-4">
                {{ Str::limit($task['description'], 70) }}
            </p>
        @endif

        <!-- Dates and Priority -->
        <div class="space-y-3">
            <!-- Creation and Due Date -->
            <div class="flex flex-col space-y-2">
                <div class="flex items-center text-xs text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Created {{ \Carbon\Carbon::parse($task['created_at'])->diffForHumans() }}</span>
                </div>

                <div class="flex items-center text-xs text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    @if(isset($task['due_date']))
                        <span>{{ \Carbon\Carbon::parse($task['due_date'])->format('m/d/Y') }}</span>
                        @if(\Carbon\Carbon::parse($task['due_date'])->isPast())
                            <span class="ml-2 text-red-500">
                                ({{ \Carbon\Carbon::parse($task['due_date'])->diffForHumans() }})
                            </span>
                        @endif
                    @else
                        <span class="text-gray-400">No due date</span>
                    @endif
                </div>
            </div>

            <!-- Priority and Client -->
            <div class="flex justify-between items-center">
                @if (isset($task['priority']))
                    <span class="inline-flex items-center px-3 py-1 rounded-full font-medium text-xs {{ $priorityColorClass }}">
                        @switch($task['priority'])
                            @case('high')
                                High Priority
                                @break
                            @case('medium')
                                Medium Priority
                                @break
                            @case('low')
                                Low Priority
                                @break
                            @case('critical')
                                Critical
                                @break
                        @endswitch
                    </span>
                @endif

                @if (!empty($clientName))
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $clientName }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>