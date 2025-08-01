document.addEventListener('DOMContentLoaded', function() {
    // Global editor instance
    let editorInstance;

    // Inicializar todos los módulos
    initializeAll();

    // Función principal de inicialización
    function initializeAll() {
        initializeEditor().then((editor) => {
            // Estos módulos dependen del editor
            setupExtraBlockGeneration();
            setupMetadataGeneration();
            setupFormSubmission();
            setupBlogPreview();
        });

        // Estos módulos pueden ejecutarse en paralelo
        setupImageGeneration();
        setupWordPressFetching();
        setupStickyElements();
    }
});