// utils.js - Funciones de utilidad compartidas

// Mostrar/ocultar spinner de carga
const showSpinner = (spinnerId) => document.getElementById(spinnerId).classList.remove('hidden');
const hideSpinner = (spinnerId) => document.getElementById(spinnerId).classList.add('hidden');

// Obtener token CSRF
const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Función unificada de alerta usando SweetAlert2
const showAlert = (type, message) => {
    Swal.fire({
        icon: type, // 'success', 'error', 'warning', 'info'
        title: type.charAt(0).toUpperCase() + type.slice(1),
        text: message,
        confirmButtonText: 'OK',
        timer: type === 'success' ? 3000 : undefined,
        timerProgressBar: type === 'success'
    });
};

// Variables globales compartidas
let imageUrl; // UR