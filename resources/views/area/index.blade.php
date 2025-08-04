<x-guest-layout>
    <div class="min-h-screen main-bg p-6">
        <div class="max-w-4xl mx-auto">
            <x-area.progress-steps />
            <div class="glass-dark rounded-2xl p-8 shadow-2xl border border-white/15 backdrop-blur-xl">
                <x-area.business-profile-step :client=$client/>
                <x-area.service-areas-step :client=$client/>
                <x-area.fleet-step :client=$client />
            </div>
        </div>
    </div>
    
    @push('styles')
    <style>
        /* Mantener todas las animaciones originales */
        .animate__animated {
            animation-duration: 0.3s;
            animation-fill-mode: both;
        }
        
        .animate__fadeOut {
            animation-name: fadeOut;
        }
        
        .animate__fadeIn {
            animation-name: fadeIn;
        }
        
        .animate__pulse {
            animation-name: pulse;
            animation-duration: 1s;
        }
        
        .animate__infinite {
            animation-iteration-count: infinite;
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Estilos para los step indicators en tema oscuro */
        .step-indicator {
            transition: all 0.3s ease;
        }
        
        .step-indicator:hover {
            transform: translateY(-2px);
        }
        
        /* Progress bar styling */
        #progress-bar {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 9999px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
    </style>
    @endpush

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const steps = document.querySelectorAll('.form-step');
                const stepIndicators = document.querySelectorAll('.step-indicator');
                let currentStep = 1;

                // Inicialización
                showStep(currentStep);
                updateProgress();

                // Eventos para los indicadores de paso
                stepIndicators.forEach(indicator => {
                    indicator.addEventListener('click', () => {
                        const stepNumber = parseInt(indicator.dataset.step);
                        if (stepNumber <= currentStep + 1) {
                            navigateToStep(stepNumber);
                        }
                    });
                });

                // Eventos para botones siguiente/anterior
                document.addEventListener('click', e => {
                    if (e.target.matches('.next-step')) {
                        navigateToStep(currentStep + 1);
                    }
                    if (e.target.matches('.prev-step')) {
                        navigateToStep(currentStep - 1);
                    }
                });

                function navigateToStep(newStep) {
                    if (newStep < 1 || newStep > steps.length) return;

                    // Animación de salida con fade
                    const currentStepElement = steps[currentStep - 1];
                    currentStepElement.classList.add('animate__animated', 'animate__fadeOut');

                    setTimeout(() => {
                        steps.forEach(step => {
                            step.classList.add('hidden');
                            step.classList.remove('animate__animated', 'animate__fadeOut',
                                'animate__fadeIn');
                        });

                        currentStep = newStep;
                        showStep(currentStep);
                        updateProgress();
                    }, 300);
                }

                function showStep(stepNumber) {
                    const targetStep = steps[stepNumber - 1];
                    targetStep.classList.remove('hidden');
                    targetStep.classList.add('animate__animated', 'animate__fadeIn');
                }

                function updateProgress() {
                    // Actualizar barra de progreso con animación suave
                    const progressBar = document.getElementById('progress-bar');
                    const progress = ((currentStep - 1) / (steps.length - 1)) * 100;
                    progressBar.style.transition = 'width 0.3s ease-in-out';
                    progressBar.style.width = `${progress}%`;

                    // Actualizar indicadores
                    stepIndicators.forEach((indicator, index) => {
                        const stepNum = index + 1;
                        const icon = indicator.querySelector('div:first-child');
                        const text = indicator.querySelector('span');
                        const iconElement = icon.querySelector('i');

                        // Limpiar clases anteriores
                        icon.className =
                            'w-12 h-12 rounded-full glass border-4 flex items-center justify-center shadow-lg transform transition-all duration-300 hover:scale-110 backdrop-blur-xl';
                        iconElement.className =
                            `fas fa-${getIconName(stepNum)} text-xl transition-all duration-300`;
                        text.className = 'mt-2 font-medium text-sm transition-all duration-300';

                        if (stepNum < currentStep) {
                            // Paso completado
                            icon.classList.add('border-emerald-500', 'bg-emerald-500/20');
                            iconElement.classList.add('text-emerald-400');
                            text.classList.add('text-emerald-400');
                            indicator.style.cursor = 'pointer';
                        } else if (stepNum === currentStep) {
                            // Paso actual
                            icon.classList.add('border-blue-500', 'bg-blue-500/20', 'animate__animated', 'animate__pulse',
                                'animate__infinite');
                            iconElement.classList.add('text-blue-400');
                            text.classList.add('text-blue-400');
                            indicator.style.cursor = 'pointer';
                        } else {
                            // Pasos futuros
                            icon.classList.add('border-slate-600', 'bg-slate-600/20');
                            iconElement.classList.add('text-slate-500');
                            text.classList.add('text-slate-500');
                            indicator.style.cursor = 'not-allowed';
                        }
                    });
                }

                function getIconName(stepNum) {
                    const icons = ['building', 'map-marked-alt', 'car'];
                    return icons[stepNum - 1] || 'circle';
                }
            });
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @endpush
</x-guest-layout>
