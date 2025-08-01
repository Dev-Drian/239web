// Procesar archivo CSV cargado
function handleCsvUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const text = e.target.result;
        const lines = text.split('\n');
        const newKeywords = lines
            .slice(1)
            .filter(line => line.trim())
            .map(line => {
                const parts = line.split(',');
                return {
                    keyword: parts[0].trim(),
                    searchVolume: parts[1] ? parts[1].trim() : 'N/A',
                    cpc: parts[2] ? parts[2].trim() : 'N/A'
                };
            });

        // Eliminar duplicados del archivo CSV y de keywords existentes
        const uniqueKeywords = [...keywords]; // Mantener keywords actuales
        newKeywords.forEach(k => {
            if (!uniqueKeywords.some(uk => uk.keyword.toLowerCase() === k.keyword.toLowerCase())) {
                uniqueKeywords.push(k);
            }
        });

        if (uniqueKeywords.length > 50) {
            keywords = uniqueKeywords.slice(0, 50); // Limitar a 50 keywords
            showAlert('warning', 'Advertencia',
                'Solo se permiten un máximo de 50 keywords.');
        } else {
            keywords = uniqueKeywords;
        }

        $('#totalCountLoader').text(keywords.length);
        populateInitialTable(keywords);
    };
    reader.readAsText(file);
}

function loadSavedResults() {
    $.ajax({
        url: keywordHistoryRoute,  // Define this global variable with the route
        method: 'GET',
        success: function (response) {
            if (response.data && response.data.length > 0) {
                results = response.data; // Guardar los resultados cargados en la variable global

                // Convertir los resultados al formato de keywords
                keywords = response.data.map(item => ({
                    keyword: item.keyword,
                    searchVolume: item.searchVolume || 'N/A',
                    cpc: item.cpc || 'N/A'
                }));


                displaySavedResults(response.data);
                populateInitialTable(keywords);
                $('#totalCountLoader').text(keywords.length);
            } else {
                results = []; // Si no hay resultados, limpiar la variable
                keywords = []; // También limpiar keywords para empezar de cero
            }
        },
        error: function (xhr) {
            console.error('Error loading history:', xhr);
        }
    });
}


// Añadir keyword manualmente
function addKeywordManually() {
    const manualKeyword = $('#manualKeyword').val().trim();
    if (manualKeyword) {
        if (keywords.length >= 50) {
            showAlert('warning', 'Límite alcanzado', 'Has alcanzado el límite de 50 keywords.');
            return;
        }
        if (isKeywordDuplicate(manualKeyword)) {
            showAlert('warning', 'Keyword duplicada', 'La keyword ya existe en la lista.');
            return;
        }
        keywords.push({
            keyword: manualKeyword,
            searchVolume: 'N/A',
            cpc: 'N/A'
        });
        $('#manualKeyword').val('');
        $('#totalCountLoader').text(keywords.length);
        populateInitialTable(keywords);
    }
}

// Manejar envío del formulario
function handleFormSubmission(e) {
    e.preventDefault();

    const searchUrl = $('#searchUrl').val();
    const location = $('#location').val();

    if (!searchUrl || !location || !keywords.length) {
        showAlert('error', 'Campos incompletos',
            'Por favor complete todos los campos y cargue las keywords.');
        return;
    }

    if (!isValidUrl(searchUrl)) {
        showAlert('error', 'Enlace inválido', 'Por favor ingrese un enlace válido.');
        return;
    }

    showLoader();
    processedCount = 0;
    results = []; // Limpiar resultados anteriores
    startTimer(keywords.length);
    processKeywordsSequentially(keywords, searchUrl, location);
}

// Procesar keywords secuencialmente
function processKeywordsSequentially(keywords, searchUrl, location) {
    let index = 0;

    function processNextKeyword() {
        if (index >= keywords.length) {
            hideLoader();
            clearInterval(intervalId);
            return;
        }

        const keywordData = keywords[index];
        
        $.ajax({
            url: keywordPositionRoute,
            method: 'POST',
            data: {
                _token: csrfToken,
                keyword: keywordData.keyword,
                searchUrl: searchUrl,
                location: location
            },
            success: function (response) {
                // Check if response.data exists before accessing properties
                if (response && response.data) {
                    // Guardar resultados para luego almacenarlos en BD
                    results.push({
                        keyword: keywordData.keyword,
                        position: response.data.position || 'Not Found',
                        searchVolume: keywordData.searchVolume,
                        cpc: keywordData.cpc,
                        url: response.data.url || '',
                        date: new Date().toISOString().split('T')[0] 
                    });
                    console.log(response.data.position);
                    $('#availableCredits').text(response.credits);
                        if (response.data.position >= 1 && response.data.position <= 10) {
                            firstPageCount++;
                        } else if (response.data.position >= 11 && response.data.position <= 20) {
                            secondPageCount++;
                        } else if (response.data.position >= 21 && response.data.position <= 100) {
                            thirdToTenthPageCount++;
                        }

                    updateTableRow(keywordData.keyword, response.data, keywordData.searchVolume, keywordData.cpc);
                } else {
                    // Handle case where response.data is undefined
                    console.warn('Response data undefined for keyword:', keywordData.keyword);
                    results.push({
                        keyword: keywordData.keyword,
                        position: 'Not Found',
                        searchVolume: keywordData.searchVolume,
                        cpc: keywordData.cpc,
                        url: '',
                        date: new Date().toISOString().split('T')[0]
                    });

                    // Update table with default values
                    updateTableRow(keywordData.keyword, { position: 'Not Found', url: '' }, keywordData.searchVolume, keywordData.cpc);
                }

                processedCount++;
                $('#processedCountLoader').text(processedCount);
                updateProgress(processedCount, keywords.length);
                index++;
                processNextKeyword();
            },
            error: function (xhr) {
                console.error('Error procesando keyword:', keywordData.keyword, xhr);

                // Add to results with error indication
                results.push({
                    keyword: keywordData.keyword,
                    position: 'Error',
                    searchVolume: keywordData.searchVolume,
                    cpc: keywordData.cpc,
                    url: '',
                    date: new Date().toISOString().split('T')[0]
                });

                // Update table with error
                updateTableRow(keywordData.keyword, { position: 'Error', url: '' }, keywordData.searchVolume, keywordData.cpc);

                processedCount++;
                $('#processedCountLoader').text(processedCount);
                updateProgress(processedCount, keywords.length);
                index++;
                processNextKeyword();
            }
        });
    }

    processNextKeyword();
}

// Actualizar fila de la tabla con resultados

// Obtener datos de volumen y CPC para todas las keywords
// Get volume and CPC data for all keywords
function getKeywordData() {
    if (keywords.length === 0) {
        showAlert('warning', 'No Keywords', 'There are no keywords to process.');
        return;
    }

    $('#getKeywordData').prop('disabled', true);
    $('#getKeywordData').html('<i class="fas fa-spinner fa-spin"></i> Processing...');

    // Get only the keywords (without additional data)
    const keywordStrings = keywords.map(k => k.keyword);

    $.ajax({
        url: dataForSeoRoute,  // Define this variable globally with the route
        method: 'POST',
        data: {
            _token: csrfToken,  // Define this variable globally
            keywords: keywordStrings
        },
        success: function (response) {
            if (response.success) {
                $('#availableCredits').text(response.credits);

                // Save current positions and URLs before updating
                const currentData = {};
                $('#resultsBody tr').each(function() {
                    const keyword = $(this).data('keyword');
                    const position = $(this).find('td:eq(1)').text();
                    const url = $(this).find('td:eq(3)').text();
                    
                    // Save only if it has a real position (not "Pending")
                    if (position !== 'Pending') {
                        currentData[keyword] = {
                            position: position,
                            url: url
                        };
                    }
                });

                // Update data in the keywords array
                response.data.forEach(item => {
                    const index = keywords.findIndex(k => k.keyword === item.keyword);
                    if (index !== -1) {
                        keywords[index].searchVolume = item.search_volume;
                        keywords[index].cpc = item.cpc;

                        // Also update the results if they exist
                        const resultIndex = results.findIndex(r => r.keyword === item.keyword);
                        if (resultIndex !== -1) {
                            results[resultIndex].searchVolume = item.search_volume;
                            results[resultIndex].cpc = item.cpc;
                        }
                    }
                });

                // Update the table with the new data
                populateInitialTable(keywords);

                // Restore positions and URLs after updating the table
                for (const keyword in currentData) {
                    const row = $(`#resultsBody tr[data-keyword="${keyword}"]`);
                    if (row.length) {
                        const data = currentData[keyword];
                        row.find('td:eq(1)').text(data.position);
                        row.find('td:eq(3)').text(data.url);
                        
                        // Restore colors based on position
                        const position = parseInt(data.position);
                        row.removeClass('bg-green-50 bg-yellow-50 bg-red-50');
                        
                        if (position && position <= 10) {
                            row.addClass('bg-green-50');
                        } else if (position && position <= 20) {
                            row.addClass('bg-yellow-50');
                        } else if (position && !isNaN(position)) {
                            row.addClass('bg-red-50');
                        }
                    }
                }

                showAlert('success', 'Data Updated', 'All keyword data has been updated.');
            } else {
                showAlert('error', 'Error', response.message || 'Could not retrieve the data.');
            }
        },
        error: function (xhr) {
            showAlert('error', 'Error', 'Could not retrieve the data. Please try again.');
        },
        complete: function () {
            $('#getKeywordData').prop('disabled', false);
            $('#getKeywordData').html('<i class="fas fa-sync"></i> Volumes & CPC');
        }
    });
}


// Eliminar keyword de la lista
function removeKeywordFromList(keyword) {
    const index = keywords.findIndex(k => k.keyword === keyword);
    if (index !== -1) {
        keywords.splice(index, 1);
        $('#totalCountLoader').text(keywords.length);
        populateInitialTable(keywords);
    }
}

// Llenar tabla inicial con las keywords
function populateInitialTable(keywords) {
    const tbody = $('#resultsBody');
    tbody.empty();

    keywords.forEach((keyword, index) => {
        tbody.append(`
        <tr data-keyword="${keyword.keyword}">
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
                <!-- URL se llenará después -->
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <button onclick="removeKeyword('${keyword.keyword}')" class="deleteKeywordBtn text-red-600 hover:text-red-800 focus:outline-none">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${keyword.cpc}
            </td>
        </tr>
    `);
    });

    // Reasignar eventos a los botones de eliminar
    $('.deleteKeywordBtn').off('click').on('click', function () {
        const row = $(this).closest('tr');
        const keyword = row.data('keyword');
        removeKeyword(keyword);
        row.remove();
    });
}

// Botón Top Keywords (Integrado con el sistema)
document.getElementById('topKeywords').addEventListener('click', function () {
    const topKeywordsList = [
        "Limo service", "Limousine rental", "Luxury transportation",
        "Airport limo service", "Wedding limo rental", "Corporate limo service",
        "Party bus rental", "Stretch limousine", "Chauffeur service",
        "VIP transportation", "Executive car service", "Prom limo rental",
        "Hourly limo rental", "SUV limo service", "Mercedes Sprinter rental",
        "Rolls Royce limousine", "Affordable limo service", "Group transportation",
        "Special event transportation", "Night out limo service", "Wine tour limo",
        "Concert transportation", "Bachelor/bachelorette party limo",
        "Luxury sedan rental", "City tour limousine", "Anniversary limo service",
        "Graduation limo rental", "Airport shuttle service", "Long-distance limo service"
    ];

    // Combinar con keywords existentes evitando duplicados
    const combinedKeywords = [...keywords];
    topKeywordsList.forEach(k => {
        if (!combinedKeywords.some(ek => ek.keyword.toLowerCase() === k.toLowerCase())) {
            combinedKeywords.push({
                keyword: k,
                searchVolume: 'N/A',
                cpc: 'N/A'
            });
        }
    });

    // Limitar a 50 y actualizar
    if (combinedKeywords.length > 50) {
        keywords = combinedKeywords.slice(0, 50);
        showAlert('warning', 'Límite alcanzado', 'Se han conservado las primeras 50 keywords.');
    } else {
        keywords = combinedKeywords;
    }

    // Actualizar interfaz
    $('#totalCountLoader').text(keywords.length);
    populateInitialTable(keywords);
});
// Obtener datos de volumen y CPC para todas las keywords

// Actualizar fila de la tabla con resultados
function updateTableRow(keyword, data, searchVolume, cpc) {
    const row = $(`#resultsBody tr[data-keyword="${keyword}"]`);

    row.find('td:eq(1)').text(data.position || 'No encontrado');
    row.find('td:eq(2)').text(searchVolume);
    row.find('td:eq(3)').text(data.url || '');
    row.find('td:eq(5)').text(cpc);

    const position = parseInt(data.position);
    row.removeClass('bg-green-50 bg-yellow-50 bg-red-50');

    if (position && position <= 10) {
        row.addClass('bg-green-50');
    } else if (position && position <= 20) {
        row.addClass('bg-yellow-50');
    } else if (position) {
        row.addClass('bg-red-50');
    }
}