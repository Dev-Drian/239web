{{-- filepath: c:\xampp\htdocs\limo-partner\resources\views\components\ads\campaign-preview.blade.php --}}
<div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
    <button type="button" id="previewButton"
        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
        <svg id="previewIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
            <path fill-rule="evenodd"
                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                clip-rule="evenodd" />
        </svg>
        <span id="previewButtonText">View Preview</span>
    </button>
    <button type="submit" id="submitButton"
        class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
        </svg>
        <span>Create Campaign</span>
    </button>
</div>

<div id="campaignPreview" class="mt-6 transition-all duration-300 opacity-0 max-h-0 overflow-hidden">
    <div class="bg-white border border-gray-200 rounded-lg shadow-md">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4 rounded-t-lg">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <h3 id="previewTemplate" class="text-xl font-bold"></h3>
                <div class="bg-white text-blue-800 px-4 py-1 rounded-full text-sm font-semibold shadow-sm">
                    Budget: $<span id="previewBudget"></span>/day
                </div>
            </div>
            <p id="previewLocation" class="text-blue-100 mt-1 text-sm"></p>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Campaign Details -->
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                        Target Area
                    </h4>
                    <p id="previewTargetArea" class="text-gray-700"></p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                        Schedule
                    </h4>
                    <p id="previewSchedule" class="text-gray-700"></p>
                </div>
            </div>

            <!-- Keywords Section -->
            <div id="previewKeywords" class="hidden">
                <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                    Palabras Clave
                </h4>
                <div class="flex flex-wrap gap-2 bg-gray-50 p-4 rounded-lg border border-gray-100"></div>
            </div>

            <!-- Ads Section -->
            <div id="previewAds" class="hidden">
                <h4 class="font-bold text-gray-800 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Generated Ads
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="adsContainer"></div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewButton = document.getElementById('previewButton');
            const previewButtonText = document.getElementById('previewButtonText');
            const previewIcon = document.getElementById('previewIcon');
            const campaignPreview = document.getElementById('campaignPreview');
            let previewVisible = false;

            // Verificar si los elementos existen antes de continuar
            if (!previewButton || !campaignPreview) {
                console.error('Required elements not found');
                return;
            }

            // Toggle preview visibility
            previewButton.addEventListener('click', function() {
                try {
                    if (!previewVisible) {
                        generatePreview();
                        showPreview();
                    } else {
                        hidePreview();
                    }
                } catch (error) {
                    console.error('Error toggling preview:', error);
                    alert(
                        'Error al generar la vista previa. Por favor revise la consola para más detalles.'
                    );
                }
            });

            function showPreview() {
                // Animación suave para mostrar el preview
                campaignPreview.classList.remove('opacity-0', 'max-h-0');
                campaignPreview.classList.add('opacity-100');
                campaignPreview.style.maxHeight =
                    '2000px'; // Valor alto para asegurar que todo el contenido sea visible

                // Cambiar el botón a "ocultar"
                previewButtonText.textContent = 'Ocultar Vista Previa';
                previewIcon.innerHTML =
                    '<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>';
                previewVisible = true;

                // Desplazar automáticamente hacia el preview
                setTimeout(() => {
                    campaignPreview.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            }

            function hidePreview() {
                // Animación suave para ocultar el preview
                campaignPreview.classList.remove('opacity-100');
                campaignPreview.classList.add('opacity-0');
                campaignPreview.style.maxHeight = '0';

                // Cambiar el botón a "ver"
                previewButtonText.textContent = 'Ver Vista Previa';
                previewIcon.innerHTML =
                    '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />';
                previewVisible = false;
            }

            function generatePreview() {
                console.log('Generated Ads:', window.generatedAds);

                // Obtener el formulario padre más cercano
                const form = previewButton.closest('form');
                if (!form) {
                    throw new Error('Form not found');
                }

                // Obtener valores del formulario con valores por defecto
                const getValue = (selector, defaultValue = 'No especificado') => {
                    const element = form.querySelector(selector);
                    return element && element.value ? element.value : defaultValue;
                };

                const formData = {
                    template: getValue('[name="campaign_template"]'),
                    location: getValue('[name="user_location"]'),
                    budget: getValue('[name="daily_budget"]', '0'),
                    targetArea: getValue('[name="target_area"]'),
                    schedule: {
                        days: getSelectedDays(),
                        start: getValue('[name="ad_schedule[start_time]"]'),
                        end: getValue('[name="ad_schedule[end_time]"]')
                    },
                    keywords: window.getSelectedKeywords ? window.getSelectedKeywords() : [],
                    ads: window.generatedAds || [],
                };

                // Actualizar el contenido del preview
                document.getElementById('previewTemplate').textContent = formData.template;
                document.getElementById('previewLocation').textContent = formData.location;
                document.getElementById('previewBudget').textContent = formData.budget;
                document.getElementById('previewTargetArea').textContent = formData.targetArea;

                // Formatear el horario para la vista previa
                const scheduleText = formatScheduleForPreview(formData.schedule.days, formData.schedule.start,
                    formData.schedule.end);
                document.getElementById('previewSchedule').textContent = scheduleText;

                // Actualizar keywords y ads si existen
                if (formData.keywords && formData.keywords.length > 0) {
                    updateKeywordsPreview(formData.keywords);
                }

                if (formData.ads && formData.ads.length > 0) {
                    updateAdsPreview(formData.ads);
                }
            }

            // Función para formatear el horario
            function formatScheduleForPreview(days, startTime, endTime) {
                if (days.length === 0 || startTime === 'No especificado' || endTime === 'No especificado') {
                    return 'Horario no especificado';
                }

                const dayNames = {
                    'MONDAY': 'Lunes',
                    'TUESDAY': 'Martes',
                    'WEDNESDAY': 'Miércoles',
                    'THURSDAY': 'Jueves',
                    'FRIDAY': 'Viernes',
                    'SATURDAY': 'Sábado',
                    'SUNDAY': 'Domingo'
                };

                // Convertir a nombres en español
                const spanishDays = days.map(day => dayNames[day] || day);

                // Casos especiales
                let daysText;
                if (spanishDays.length === 5 &&
                    spanishDays.includes('Lunes') &&
                    spanishDays.includes('Martes') &&
                    spanishDays.includes('Miércoles') &&
                    spanishDays.includes('Jueves') &&
                    spanishDays.includes('Viernes')) {
                    daysText = 'Lunes a Viernes';
                } else if (spanishDays.length === 2 &&
                    spanishDays.includes('Sábado') &&
                    spanishDays.includes('Domingo')) {
                    daysText = 'Fin de semana';
                } else if (spanishDays.length === 7) {
                    daysText = 'Todos los días';
                } else {
                    daysText = spanishDays.join(', ');
                }

                return `${daysText} (${startTime} - ${endTime})`;
            }

            // Función para obtener días seleccionados
            function getSelectedDays() {
                const selectedDays = [];
                document.querySelectorAll('input[name="ad_schedule[days][]"]:checked').forEach(checkbox => {
                    selectedDays.push(checkbox.value);
                });
                return selectedDays;
            }

            // Función para actualizar preview de keywords
            function updateKeywordsPreview(keywords) {
                const container = document.querySelector('#previewKeywords > div');
                if (!container) return;

                container.innerHTML = '';
                keywords.forEach(keyword => {
                    const pill = document.createElement('span');
                    pill.className =
                        'bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium border border-blue-100';
                    pill.textContent = typeof keyword === 'object' ? keyword.text : keyword;
                    container.appendChild(pill);
                });
                document.getElementById('previewKeywords').classList.remove('hidden');
            }

            // Función para actualizar preview de anuncios
            function updateAdsPreview(ads) {

                const container = document.querySelector('#previewAds > div');
                if (!container) return;

                container.innerHTML = '';

                // Aseguramos que todos los anuncios se muestren correctamente
                ads.forEach((ad, index) => {
                    const adElement = document.createElement('div');
                    adElement.className =
                        'border border-gray-200 bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow';

                    // Renderizar titulares (headlines)
                    const headlines = ad.headlines
                        .map((headline) => `<li>${headline.text || 'No headline'}</li>`)
                        .join('');

                    // Renderizar descripciones
                    const descriptions = ad.descriptions
                        .map((description) => `<li>${description.text || 'No description'}</li>`)
                        .join('');

                    // Contenido del anuncio
                    adElement.innerHTML = `
                                <h5 class="font-bold text-blue-800 text-lg mb-2">Headlines</h5>
                                <ul class="list-disc pl-5 mb-4">${headlines}</ul>
                                <h5 class="font-bold text-blue-800 text-lg mb-2">Descriptions</h5>
                                <ul class="list-disc pl-5 mb-4">${descriptions}</ul>
                                <p class="text-sm text-gray-600"><strong>Path 1:</strong> ${ad.path1 || 'N/A'}</p>
                                <p class="text-sm text-gray-600"><strong>Path 2:</strong> ${ad.path2 || 'N/A'}</p>
                                <p class="text-sm text-gray-600"><strong>Final URL:</strong> <a href="${ad.final_url}" target="_blank" class="text-blue-500 underline">${ad.final_url}</a></p>
                            `;

                    container.appendChild(adElement);
                });

                document.getElementById('previewAds').classList.remove('hidden');
            }

            // Verificar si hay datos de anuncios o keywords disponibles en la carga inicial
            if (window.getSelectedKeywords && window.getSelectedKeywords().length > 0) {
                updateKeywordsPreview(window.getSelectedKeywords());
            }

            if (window.generatedAds && window.generatedAds.length > 0) {

                updateAdsPreview(window.generatedAds);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const previewAds = window.generatedAds || [];
            const adsContainer = document.getElementById('adsContainer');

            function renderAds(ads) {
                adsContainer.innerHTML = ''; // Clear previous ads
                ads.forEach(ad => {
                    const adElement = document.createElement('div');
                    adElement.className = 'border border-gray-200 bg-white p-4 rounded-lg shadow-sm';

                    const headlines = ad.headlines.map(h => `<li>${h.text}</li>`).join('');
                    const descriptions = ad.descriptions.map(d => `<li>${d.text}</li>`).join('');

                    adElement.innerHTML = `
                        <h5 class="font-bold text-blue-800 text-lg mb-2">Headlines</h5>
                        <ul class="list-disc pl-5 mb-4">${headlines}</ul>
                        <h5 class="font-bold text-blue-800 text-lg mb-2">Descriptions</h5>
                        <ul class="list-disc pl-5 mb-4">${descriptions}</ul>
                        <p class="text-sm text-gray-600"><strong>Path 1:</strong> ${ad.path1 || 'N/A'}</p>
                        <p class="text-sm text-gray-600"><strong>Path 2:</strong> ${ad.path2 || 'N/A'}</p>
                        <p class="text-sm text-gray-600"><strong>Final URL:</strong> <a href="${ad.final_url}" target="_blank" class="text-blue-500 underline">${ad.final_url}</a></p>
                    `;

                    adsContainer.appendChild(adElement);
                });
                document.getElementById('previewAds').classList.remove('hidden');
            }

            renderAds(previewAds);
        });
    </script>
@endpush
