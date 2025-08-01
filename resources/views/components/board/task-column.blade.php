<div x-data="{
    initSortable() {
        new Sortable(this.$el.querySelector('.task-list'), {
            group: {
                name: 'tasks',
                pull: true,
                put: true
            },
            animation: 150,
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            chosenClass: 'sortable-chosen',
            emptyInsertThreshold: 30, /* Facilita la inserción en áreas vacías */
            handle: '.task-card', // Especificar el handle para el drag
            onStart: function(evt) {
                evt.item.classList.add('dragging');
            },
            onEnd: function(evt) {
                evt.item.classList.remove('dragging');
                const fromStatus = evt.from.closest('[data-status]').dataset.status;
                const toStatus = evt.to.closest('[data-status]').dataset.status;
                const taskId = evt.item.dataset.id;

                if (fromStatus === toStatus) {
                    const orderedIds = Array.from(evt.to.children)
                        .filter(el => el.dataset.id)
                        .map(el => el.dataset.id);

                    @this.call('updateTaskOrder', orderedIds, toStatus);
                } else {
                    @this.call('moveTask', taskId, toStatus);
                }
            }
        });
    }
}" x-init="initSortable()" wire:key="{{ $status }}-column" data-status="{{ $status }}"
    class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.01] flex flex-col">

    <div class="bg-gradient-to-r from-{{ $color }}-500 to-{{ $color }}-600 p-4 rounded-t-lg">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="{{ $icon }}" clip-rule="evenodd" />
                </svg>
                {{ $title }}
            </h2>
            <span
                class="bg-white text-{{ $color }}-700 border border-{{ $color }}-200 rounded-full px-3 py-1 text-sm font-medium shadow-sm">
                {{ count($tasks) }}
            </span>
        </div>
    </div>
    <!-- Eliminar max-height y overflow-y-auto para que las tarjetas aparezcan sin scroll -->
    <div class="task-list p-4 space-y-3 min-h-64 overflow-x-hidden flex-grow">
        @forelse ($tasks as $task)
            <x-board.task-card
                :task="$task"
                :status="$status"
                :color="$color"
                :client-name="$task['board']['client']['name'] ?? null"
            />
        @empty
            <div
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-400 hover:border-{{ $color }}-300 hover:text-{{ $color }}-500 transition-colors duration-300 h-full min-h-[150px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                </svg>
                <p>No {{ strtolower($title) }} tasks</p>
            </div>
        @endforelse
    </div>
</div>
