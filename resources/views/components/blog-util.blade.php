<script>
// utils.js - Funciones de utilidad compartidas

// Mostrar/ocultar spinner de carga
const showSpinner = (spinnerId) => {
    const spinner = document.getElementById(spinnerId);
    if (spinner) {
        spinner.classList.remove('hidden');
    } else {
        console.warn(`Spinner element with id '${spinnerId}' not found`);
    }
};

const hideSpinner = (spinnerId) => {
    const spinner = document.getElementById(spinnerId);
    if (spinner) {
        spinner.classList.add('hidden');
    } else {
        console.warn(`Spinner element with id '${spinnerId}' not found`);
    }
};

// Obtener token CSRF
const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Función unificada de alerta usando SweetAlert2
const showAlert = (type, message) => {
    Swal.fire({
        icon: type,
        title: type.charAt(0).toUpperCase() + type.slice(1),
        text: message,
        confirmButtonText: 'OK',
        timer: type === 'success' ? 3000 : undefined,
        timerProgressBar: type === 'success'
    });
};

// Variables globales compartidas
let imageUrl = null;
</script> 