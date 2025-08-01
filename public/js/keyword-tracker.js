$(document).ready(function() {
    let keywords = [];
    let processedCount = 0;

    // Manejo del archivo CSV
    $('#csvFile').on('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const text = e.target.result;
            const lines = text.split('\n');
            keywords = lines
                .slice(1) // Ignorar encabezado
                .filter(line => line.trim())
                .map(line => {
                    const parts = line.split(',');
                    return {
                        keyword: parts[0].trim(),
                        searchVolume: parts[1] ? parts[1].trim() : 'N/A'
                    };
                });

            $('#totalCount').text(keywords.length);
            populateInitialTable(keywords);
        };
        reader.readAsText(file);
    });

    // Añadir keyword manualmente
    $('#addKeyword').click(function() {
        const manualKeyword = $('#manualKeyword').val().trim();
        if (manualKeyword) {
            keywords.push({
                keyword: manualKeyword,
                searchVolume: 'N/A'
            });
            $('#manualKeyword').val(''); // Limpiar el campo
            $('#totalCount').text(keywords.length);
            populateInitialTable(keywords);
        }
    });

    // Manejo del formulario
    $('#keywordForm').on('submit', function(e) {
        e.preventDefault(); // Evitar que el formulario se recargue

        const searchUrl = $('#searchUrl').val();
        const location = $('#location').val();

        if (!searchUrl || !location || !keywords.length) {
            alert('Por favor complete todos los campos y cargue las keywords');
            return;
        }

        $('#progressInfo').removeClass('hidden');
        processedCount = 0;
        processKeywords(keywords, searchUrl, location);
    });

    function populateInitialTable(keywords) {
        const tbody = $('#resultsBody');
        tbody.empty();

        keywords.forEach(keyword => {
            tbody.append(`
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        ${keyword.keyword}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Pendiente
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${keyword.searchVolume}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                    </td>
                </tr>
            `);
        });
    }

    function processKeywords(keywords, searchUrl, location) {
        keywords.forEach((keywordData, index) => {
            setTimeout(() => {
                $.ajax({
                    url: '{{ route("keyword.position") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        keyword: keywordData.keyword,
                        searchUrl: searchUrl,
                        location: location
                    },
                    success: function(response) {
                        updateTableRow(keywordData.keyword, response.data);
                        updateProgress();
                    },
                    error: function(xhr) {
                        console.error('Error procesando keyword:', keywordData.keyword);
                        updateProgress();
                    }
                });
            }, index * 1000);
        });
    }

    function updateTableRow(keyword, data) {
        const row = $(`#resultsBody tr:contains('${keyword}')`);

        // Actualizar datos
        row.find('td:eq(1)').text(data.position || 'No encontrado');
        row.find('td:eq(3)').text(data.url || '');

        // Aplicar colores según posición
        const position = parseInt(data.position);
        row.removeClass('bg-green-50 bg-yellow-50 bg-red-50');

        if (position && position <= 10) {
            row.addClass('bg-green-50');
        } else if (position && position <= 20) {
            row.addClass('bg-yellow-50');
        } else if (position) {
            row.addClass('bg-red-50');
        }

        updateStatistics();
    }

    function updateProgress() {
        processedCount++;
        $('#processedCount').text(processedCount);

        if (processedCount === keywords.length) {
            updateStatistics();
        }
    }

    function updateStatistics() {
        const firstPage = $('#resultsBody tr.bg-green-50').length;
        const secondPage = $('#resultsBody tr.bg-yellow-50').length;
        const otherPages = $('#resultsBody tr.bg-red-50').length;

        $('#firstPageCount').text(firstPage);
        $('#secondPageCount').text(secondPage);
        $('#otherPagesCount').text(otherPages);
    }

    // Exportar a CSV
    $('#exportCsv').click(function() {
        let csv = 'Keyword,Posición,Search Volume,URL\n';

        $('#resultsBody tr').each(function() {
            const cells = $(this).find('td');
            const row = [
                cells.eq(0).text(),
                cells.eq(1).text(),
                cells.eq(2).text(),
                cells.eq(3).text()
            ].map(text => `"${text}"`).join(',');
            csv += row + '\n';
        });

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.setAttribute('download', 'keyword_results.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Guardar resultados
    $('#saveResults').click(function() {
        const results = [];
        $('#resultsBody tr').each(function() {
            const cells = $(this).find('td');
            results.push({
                keyword: cells.eq(0).text(),
                position: cells.eq(1).text(),
                searchVolume: cells.eq(2).text(),
                url: cells.eq(3).text()
            });
        });

        $.ajax({
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                results: results
            },
            success: function(response) {
                alert('Resultados guardados exitosamente');
            },
            error: function(xhr) {
                alert('Error al guardar los resultados');
                console.error(xhr);
            }
        });
    });
});
