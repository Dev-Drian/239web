$(document).ready(function () {
    const KeywordManager = {
        keywordCount: 0,
        maxKeywords: 50,
        keywords: new Set(),
        currentCity: '',
        keywordData: new Map(),
        processingQueue: new Set(),
        topKeywordsList: [
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
        ],
        positionCounts: {
            firstPage: 0,
            secondPage: 0,
            otherPages: 0
        },

        removeCityFromKeywords: function () {
            if (!this.currentCity) return;

            const newKeywords = new Set();
            const newKeywordData = new Map();

            for (let keyword of this.keywords) {
                const newKeyword = keyword.replace(` ${this.currentCity}`, '');
                newKeywords.add(newKeyword);
                newKeywordData.set(newKeyword, this.keywordData.get(keyword) || {
                    position: '-',
                    search_volume: '-',
                    cpc: '-',
                    url: '-',
                    difficulty: '-'
                });
            }

            this.keywords = newKeywords;
            this.keywordData = newKeywordData;
            this.currentCity = '';
            this.renderTable();
        },

        removeNotFoundKeywords: function () {
            $('tbody tr').each(function () {
                const position = $(this).find('.position').text().toLowerCase();
                if (position === 'not found' || position === '-') {
                    const keyword = $(this).data('keyword');
                    KeywordManager.keywords.delete(keyword);
                    KeywordManager.keywordData.delete(keyword);
                    $(this).remove();
                }
            });
            this.renderTable(); // Renderizar la tabla después de eliminar las filas
        },

        updatePositionCounts: function () {
            this.positionCounts = {
                firstPage: 0,
                secondPage: 0,
                otherPages: 0
            };

            this.keywords.forEach(keyword => {
                const data = this.keywordData.get(keyword);
                const position = parseInt(data.position);

                if (!isNaN(position)) {
                    if (position <= 10) {
                        this.positionCounts.firstPage++;
                    } else if (position <= 20) {
                        this.positionCounts.secondPage++;
                    } else {
                        this.positionCounts.otherPages++;
                    }
                }
            });

            // Update the UI counters
            $('#firstPageCount').text(this.positionCounts.firstPage);
            $('#secondPageCount').text(this.positionCounts.secondPage);
            $('#otherPagesCount').text(this.positionCounts.otherPages);
        },

        // Función para agregar una keyword
        addKeyword: function (keyword, data = {}) {
            if (!keyword || typeof keyword !== 'string' || keyword.trim() === '') {
                console.error("Invalid keyword:", keyword);
                return false;
            }
        
            keyword = keyword.trim();
        
            if (this.keywordCount >= this.maxKeywords) {
                Swal.fire({
                    icon: 'error',
                    title: 'Limit Exceeded',
                    text: 'You can only add up to 50 keywords.'
                });
                return false;
            }
        
            if (!this.keywords.has(keyword)) {
                this.keywords.add(keyword);
                this.keywordCount++;
                this.keywordData.set(keyword, {
                    position: data.position || '-',
                    search_volume: data.search_volume || '-',
                    cpc: data.cpc || '-',
                    url: data.url || '-',
                    difficulty: data.difficulty || '-'
                });
                this.renderTable();
                return true;
            }
            return false;
        },

        // Función para eliminar una keyword
        removeKeyword: function (keyword) {
            if (this.keywords.has(keyword)) {
                this.keywords.delete(keyword);
                this.keywordData.delete(keyword);
                this.keywordCount--;
                this.renderTable();
            }
        },

        // Función para actualizar keywords con ciudad
        updateKeywordsWithCity: function (city) {
            if (!city || typeof city !== 'string') {
                console.error("Invalid city:", city);
                return;
            }

            const newKeywords = new Set();
            const newKeywordData = new Map();

            for (let keyword of this.keywords) {
                const newKeyword = keyword.includes(city) ? keyword : `${keyword} ${city}`;
                newKeywords.add(newKeyword);
                newKeywordData.set(newKeyword, this.keywordData.get(keyword) || {
                    position: '-',
                    search_volume: '-',
                    cpc: '-',
                    url: '-',
                    difficulty: '-'
                });
            }

            this.keywords = newKeywords;
            this.keywordData = newKeywordData;
            this.currentCity = city;
            this.renderTable();
        },

        // Función principal para procesar keywords
        processKeywords: async function () {
            if (!this.keywords.size) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Keywords',
                    text: 'Please add at least one keyword.'
                });
                return;
            }

            const searchUrl = $('#searchUrl').val().trim();
            const location = $('#location').val().trim();

            if (!searchUrl || !location) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Data',
                    text: 'Please provide both search URL and location.'
                });
                return;
            }

            const totalKeywords = this.keywords.size;
            let processedCount = 0;
            this.processingQueue.clear();

            // Mostrar el loader y el panel de estado
            $('#processingLoader').removeClass('hidden');
            $('#processingStatus').removeClass('hidden');
            $('#totalCount').text(totalKeywords);
            $('#processedCount').text(processedCount);
            $('#remainingCount').text(totalKeywords - processedCount);

            try {
                const batchSize = 5; // Procesar en lotes de 5 keywords
                const keywords = Array.from(this.keywords);

                for (let i = 0; i < keywords.length; i += batchSize) {
                    const batch = keywords.slice(i, i + batchSize);
                    const promises = batch.map(keyword => {
                        this.processingQueue.add(keyword);
                        return new Promise(resolve => setTimeout(resolve, 500))
                            .then(() => this.processKeyword(keyword, searchUrl, location))
                            .finally(() => {
                                processedCount++;
                                this.processingQueue.delete(keyword);
                                $('#processedCount').text(processedCount);
                                $('#remainingCount').text(totalKeywords - processedCount);
                                const progress = (processedCount / totalKeywords) * 100;
                                $('#progressBar').css('width', `${progress}%`);
                                $('#statusProgressBar').css('width', `${progress}%`);
                            });
                    });

                    await Promise.all(promises);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'All keywords processed successfully.'
                });

            } catch (error) {
                console.error('Error processing keywords:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing keywords.'
                });
            } finally {
                // Ocultar el loader y el panel de estado
                $('#processingLoader').addClass('hidden');
                $('#processingStatus').addClass('hidden');
            }
        },

        // Función para procesar una keyword individual
        processKeyword: function (keyword, searchUrl, location) {
            return new Promise((resolve, reject) => {
                if (this.processingQueue.has(keyword)) {
                    $.ajax({
                        type: 'POST',
                        url: keywordPositionRoute,
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        data: { keyword, searchUrl, location },
                        success: (response) => {
                            if (response.status === 'success') {
                                const currentData = this.keywordData.get(keyword) || {};
                                this.keywordData.set(keyword, {
                                    ...currentData,
                                    position: response.data.position,
                                    url: response.data.url
                                });
                                this.renderTable();
                                $('#availableCredits').text(response.credits); // Actualizar créditos
                                resolve();
                            } else {
                                console.error("Error processing keyword:", keyword, response);
                                reject(response.message || 'Error processing keyword position.');
                            }
                        },
                        error: (xhr, status, error) => {
                            console.error("Ajax error for keyword:", keyword, error);
                            reject(error);
                        }
                    });
                } else {
                    resolve(); // Skip if keyword was removed during processing
                }
            });
        },

        // Función para obtener datos de todas las keywords
        fetchAllKeywordsData: function () {
            if (!this.keywords.size) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Keywords',
                    text: 'Please add at least one keyword.'
                });
                return;
            }

            const keywordsArray = Array.from(this.keywords);

            Swal.fire({
                title: 'Processing',
                text: 'Fetching data for all keywords...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: dataForSeoRoute,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: { keywords: keywordsArray },
                success: (response) => {
                    if (response.success && Array.isArray(response.data)) {
                        response.data.forEach((keywordData) => {
                            if (this.keywords.has(keywordData.keyword)) {
                                const currentData = this.keywordData.get(keywordData.keyword) || {};
                                this.keywordData.set(keywordData.keyword, {
                                    ...currentData,
                                    search_volume: keywordData.search_volume || '-',
                                    cpc: keywordData.cpc || '-',
                                    difficulty: keywordData.difficulty || 'Not Available'
                                });
                            }
                        });

                        this.renderTable();
                        $('#availableCredits').text(response.credits); // Actualizar créditos

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: `Data updated successfully. Credits remaining: ${response.credits}`
                        });
                    } else {
                        throw new Error('Invalid response format');
                    }
                },
                error: (xhr, status, error) => {
                    console.error("Error fetching keyword data:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch keyword data. Please try again.'
                    });
                }
            });
        },

        // Función para renderizar la tabla
        renderTable: function () {
            const tbody = $('tbody');
            tbody.empty();

            this.keywords.forEach(keyword => {
                const data = this.keywordData.get(keyword) || {
                    position: '-',
                    search_volume: '-',
                    cpc: '-',
                    url: '-',
                    difficulty: '-'
                };

                // Aplicar clase solo si la posición no es '-'
                const rowClass = data.position !== '-' && String(data.position).toLowerCase() !== 'not found' ? 'bg-green-50 hover:bg-green-100' : ''; tbody.append(`
                    <tr data-keyword="${keyword}" class="${rowClass} border-b hover:bg-gray-100 transition">
                        <td class="px-4 py-3 text-left font-medium text-gray-800">${keyword}</td>
                        <td class="px-4 py-3 text-center position text-blue-600 font-semibold">${data.position}</td>
                        <td class="px-4 py-3 text-center search-volume text-green-600 font-semibold">${data.search_volume}</td>
                        <td class="px-4 py-3 text-center cpc text-purple-600 font-semibold">${data.cpc}</td>
                        <td class="px-4 py-3 text-left url text-blue-500 underline truncate max-w-[200px]">
                            <a href="${data.url}" target="_blank">${data.url}</a>
                        </td>
                        <td class="px-4 py-3 text-center difficulty text-yellow-600 font-semibold">${data.difficulty}</td>
                        <td class="px-4 py-3 text-center">
                            <button class="text-red-500 hover:text-red-700 remove-keyword flex items-center gap-1" data-keyword="${keyword}">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </td>
                    </tr>
                `);
            });
            this.updatePositionCounts();

        },

        // Función para cargar resultados guardados
        loadSavedResults: function () {
            $.ajax({
                url: keywordHistoryRoute,
                method: 'GET',
                success: function (response) {
                    if (response.success && response.data) {
                        // Convertir el objeto de datos en un array
                        const keywordArray = Object.values(response.data);
                        keywordArray.forEach(item => {
                            // Agregar la keyword al KeywordManager con todos los datos
                            KeywordManager.addKeyword(item.keyword, {
                                position: item.position,
                                search_volume: item.search_volume,
                                cpc: item.cpc,
                                url: item.url,
                                difficulty: item.difficulty
                            });
                        });

                        // Renderizar la tabla con los datos cargados
                        KeywordManager.renderTable();
                    } else {
                        console.log('No saved results found or invalid response format.');
                    }
                },
                error: function (xhr) {
                    console.error('Error loading history:', xhr);
                }
            });
        }
    };

    // Event Listeners
    $('#addKeyword').on('click', function () {
        const keyword = $('#manualKeyword').val().trim();
        if (keyword === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please enter a keyword!'
            });
            return;
        }

        if (KeywordManager.addKeyword(keyword)) {
            $('#manualKeyword').val('');
            Swal.fire({
                icon: 'success',
                title: 'Keyword Added',
                text: `"${keyword}" has been added.`
            });
        }
    });


    $('#location').on('change', function () {
        if (KeywordManager.currentCity) {
            KeywordManager.removeCityFromKeywords();
        }
    });


    $('#processKeywords').on('click', function () {
        KeywordManager.processKeywords();
    });

    $('#fetchKeywordData').on('click', function () {
        KeywordManager.fetchAllKeywordsData();
    });

    $('#removeNotFound').on('click', function () {
        KeywordManager.removeNotFoundKeywords();
    });

    $('tbody').on('click', '.remove-keyword', function () {
        const keyword = $(this).data('keyword');
        KeywordManager.removeKeyword(keyword);
    });

    $('#csvFile').on('change', function (event) {
        const file = event.target.files[0];

        if (file && file.type === 'text/csv') {
            const reader = new FileReader();
            reader.onload = function (e) {
                const keywords = e.target.result.split('\n')
                    .map(line => line.trim())
                    .filter(line => line !== '');
                let addedCount = 0;

                keywords.forEach(keyword => {
                    if (KeywordManager.addKeyword(keyword)) addedCount++;
                });

                Swal.fire({
                    icon: 'success',
                    title: 'CSV Uploaded',
                    text: `${addedCount} keywords added.`
                });
            };
            reader.readAsText(file);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File',
                text: 'Please upload a valid CSV file.'
            });
        }
    });

    $('#topKeywordsButton').on('click', function () {
        let addedCount = 0;
        KeywordManager.topKeywordsList.forEach(keyword => {
            if (KeywordManager.addKeyword(keyword)) addedCount++;
        });

        Swal.fire({
            icon: 'success',
            title: 'Top Keywords Added',
            text: `${addedCount} top keywords added.`
        });
    });


    $('#keywordsByCityButton').on('click', function () {
        const selectedCity = $('#location').val();
        if (!selectedCity) {
            Swal.fire({
                icon: 'warning',
                title: 'No City Selected',
                text: 'Please select a city.'
            });
            return;
        }

        KeywordManager.updateKeywordsWithCity(selectedCity);
        Swal.fire({
            icon: 'success',
            title: 'Keywords Updated',
            text: `Updated with city: ${selectedCity}.`
        });
    });

    // Enter key handler para el input manual
    $('#manualKeyword').on('keypress', function (e) {
        if (e.which === 13) { // Enter key
            $('#addKeyword').click();
        }
    });

    // Cargar resultados guardados al cargar la página
    KeywordManager.loadSavedResults();

    function showAlert(type, title, message) {
        Swal.fire({
            icon: type,
            title: title,
            text: message
        });
    }

    function saveResults() {
        const tableRows = $('#resultsBody tr');

        if (tableRows.length === 0) {
            showAlert('warning', 'No Results', 'There are no results to save.');
            return;
        }

        const results = [];
        tableRows.each(function () {
            const row = $(this);
            const result = {
                keyword: row.find('td:nth-child(1)').text(),
                position: row.find('td:nth-child(2)').text(),
                searchVolume: row.find('td:nth-child(3)').text(),
                cpc: row.find('td:nth-child(4)').text(),
                url: row.find('td:nth-child(5)').text(),
                difficulty: row.find('td:nth-child(6)').text()
            };
            results.push(result);
        });

        const location = $('#location').val();

        $.ajax({
            url: saveResultsRoute,
            method: 'POST',
            data: {
                _token: csrfToken,
                results: results,
                location: location
            },
            success: function (response) {
                showAlert('success', 'Save Successful', 'The results have been saved successfully.');
                KeywordManager.loadSavedResults();
            },
            error: function (xhr) {
                console.error('Error saving results:', xhr);
                showAlert('error', 'Error', 'The results could not be saved.');
            }
        });
    }

    $(document).ready(function () {
        $('#saveResults').on('click', saveResults);
    });
});