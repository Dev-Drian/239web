<x-guest-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold mt-10 mb-6 flex items-center gap-2">
                📊 Keywords Data
            </h2>

            <!-- Mostrar mensaje si no hay batches -->
            <!--@if (isset($message))
-->
            <!--    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">-->
            <!--        <p>{{ $message }}</p>-->
            <!--    </div>-->
            <!--
@endif-->

            <!-- Mostrar la tabla solo si hay datos -->
            @if (!empty($keywordsData))
                <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                    @php
                        // Calcular $maxDates solo si $keywordsData no está vacío
                        $maxDates = max(
                            array_map(function ($d) {
                                return count($d['dates']);
                            }, $keywordsData),
                        );
                    @endphp

                    <table class="min-w-full border border-gray-200">
                        <!-- Encabezados principales -->
                        <thead class="bg-blue-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left">🔤 Keyword</th>
                                @for ($i = 0; $i < $maxDates; $i++)
                                    <th class="py-3 px-4 text-center border-l border-gray-300">🗓️ Date
                                        {{ $keywordsData[0]['dates'][$i] ?? 'N/A' }}</th>
                                @endfor
                                <th class="py-3 px-4 text-center border-l border-gray-300">URL</th>
                            </tr>
                        </thead>

                        <!-- Cuerpo de la tabla -->
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($keywordsData as $data)
                                @php
                                    $isRowEmpty = true;
                                    $rowValues = [];

                                    for ($i = 0; $i < $maxDates; $i++) {
                                        $position = $data['positions'][$i] ?? 'N/A';
                                        $rowValues[] = $position;

                                        if ($position !== 'N/A' && $position !== '-') {
                                            $isRowEmpty = false;
                                        }
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50 transition">
                                    <!-- Keyword -->
                                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $data['keyword'] }}</td>

                                    @if ($isRowEmpty)
                                        <td colspan="{{ $maxDates }}" class="py-3 px-4 text-center text-gray-700">No
                                            process</td>
                                    @else
                                        @foreach ($rowValues as $position)
                                            <td class="py-3 px-4 text-center text-gray-700">{{ $position }}</td>
                                        @endforeach
                                    @endif

                                    <!-- URL -->
                                    <td class="py-3 px-4 text-center">
                                        <a href="{{ $data['urls'][0] ?? '#' }}"
                                            class="text-blue-500 hover:text-blue-600 underline">{{ $data['urls'][0] ?? 'No URL' }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
                    <p> No keyword data available.</p>
                </div>

            @endif
        </div>
    </div>
</x-guest-layout>
