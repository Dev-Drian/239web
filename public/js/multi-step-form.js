document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('.step');
    let currentStepIndex = 1;

    // Initialize steps
    initializeSteps();

    // Handle next/previous navigation
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('next-step')) {
            navigateStep(currentStepIndex + 1);
        } else if (e.target.classList.contains('prev-step')) {
            navigateStep(currentStepIndex - 1);
        } else if (e.target.closest('.step')) {
            const stepNumber = e.target.closest('.step').dataset.step;
            navigateStep(parseInt(stepNumber));
        }
    });

    function initializeSteps() {
        steps.forEach(step => step.classList.add('hidden'));
        steps[0].classList.remove('hidden');
        updateProgress(1);
    }

    function navigateStep(newStep) {
        if (newStep < 1 || newStep > steps.length) return;
        
        // Hide current step
        steps.forEach(step => step.classList.add('hidden'));
        
        // Show new step
        steps[newStep - 1].classList.remove('hidden');
        
        // Update progress
        currentStepIndex = newStep;
        updateProgress(newStep);
    }

    function updateProgress(activeStep) {
        progressSteps.forEach(step => {
            const stepNum = parseInt(step.dataset.step);
            const circle = step.querySelector('div:first-child');
            const text = step.querySelector('div:nth-child(2)');
            const bar = step.querySelector('div:last-child');
            const checkIcon = step.querySelector('.check-icon');
            const stepNumber = step.querySelector('.step-number');

            // Handle completed steps
            if (stepNum < activeStep) {
                circle.classList.replace('bg-gray-300', 'bg-green-600');
                circle.classList.replace('text-gray-600', 'text-white');
                text.classList.replace('text-gray-600', 'text-green-600');
                bar?.classList.replace('bg-gray-300', 'bg-green-600');
                checkIcon?.classList.remove('hidden');
                stepNumber?.classList.add('hidden');
            }
            // Handle active step
            else if (stepNum === activeStep) {
                circle.classList.replace('bg-gray-300', 'bg-blue-600');
                circle.classList.replace('text-gray-600', 'text-white');
                text.classList.replace('text-gray-600', 'text-blue-600');
                bar?.classList.replace('bg-gray-300', 'bg-blue-600');
            }
            // Handle upcoming steps
            else {
                circle.classList.replace('bg-blue-600', 'bg-gray-300');
                circle.classList.replace('bg-green-600', 'bg-gray-300');
                circle.classList.replace('text-white', 'text-gray-600');
                text.classList.replace('text-blue-600', 'text-gray-600');
                text.classList.replace('text-green-600', 'text-gray-600');
                bar?.classList.replace('bg-blue-600', 'bg-gray-300');
                bar?.classList.replace('bg-green-600', 'bg-gray-300');
                checkIcon?.classList.add('hidden');
                stepNumber?.classList.remove('hidden');
            }
        });
    }
});