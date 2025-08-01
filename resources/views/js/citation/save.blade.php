<script>
    $(document).ready(function() {
        $('#clientForm').on('submit', function(e) {
            e.preventDefault();

            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true);
            submitBtn.html('<i class="fas fa-spinner fa-spin mr-3"></i> Processing...');

            // Obtener todos los datos del formulario
            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Asegúrate que la respuesta es un objeto
                    if (typeof response === 'string') {
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                            return Swal.fire({
                                title: 'Error',
                                text: 'Invalid server response',
                                icon: 'error'
                            });
                        }
                    }

                    if (response.success) {
                        Swal.fire({
                            title: 'Éxito!',
                            text: response.message,
                            icon: 'success',
                            willClose: () => {
                                if (response.view) {
                                    const newWindow = window.open('', '_blank');
                                    newWindow.document.open();
                                    newWindow.document.write(response.view);
                                    newWindow.document.close();
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Ocurrió un error',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'No se pudo procesar la solicitud';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMsg = response.message || errorMsg;
                    } catch (e) {
                        console.error('Error parsing error response:', e);
                    }

                    Swal.fire({
                        title: 'Error de Conexión',
                        text: errorMsg,
                        icon: 'error'
                    });
                }
            });
        });

        // Opcional: Manejar el botón de generar contenido con AJAX si es necesario

    });
</script>
