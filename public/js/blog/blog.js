// Verificación de seguridad para variables globales
if (typeof window.website === 'undefined') {
    console.error('Website variable is not defined');
    window.website = '';
}
if (typeof window.city === 'undefined') {
    console.error('City variable is not defined');
    window.city = '';
}
if (typeof window.businessName === 'undefined') {
    console.error('Business name variable is not defined');
    window.businessName = '';
}
if (typeof window.services === 'undefined') {
    console.error('Services variable is not defined');
    window.services = [];
}
if (typeof window.blog === 'undefined') {
    console.error('Blog variable is not defined');
    window.blog = [];
}

// Log para debugging
console.log('Variables cargadas:', {
    website: window.website,
    city: window.city,
    businessName: window.businessName,
    services: window.services,
    blog: window.blog
});

// Función para abrir el modal con animación
function openModal() {
    const modal = document.getElementById('blogModal');
    const content = document.getElementById('modalContent');

    modal.classList.remove('hidden');
    // Esperar un momento para que el navegador procese el cambio antes de animar
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 50);
}

// Función para cerrar el modal con animación
function closeModal() {
    const modal = document.getElementById('blogModal');
    const content = document.getElementById('modalContent');

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    // Esperar a que termine la animación antes de ocultar el modal
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300); // Duración de la transición
}

// Función para formatear la fecha
function formatDate(dateStr) {
    const date = new Date(dateStr);
    const options = {
        year: '2-digit',
        month: 'short',
        day: '2-digit'
    };
    return date.toLocaleDateString('en-US', options).replace(',', '');
}

// Función para mostrar un mensaje cuando no hay datos
function showNoData(message) {
    $('#loadingSpinner').addClass('hidden');
    $('#blogPostsTable').addClass('hidden');
    $('#noDataMessage').removeClass('hidden');

    if (message) {
        $('#noDataMessage p').text(message);
    }
}

// Función para actualizar las estadísticas
function updateStatistics(data) {
    if (!data || !data.length) return;

    $('#totalPosts').text(data.length);

    // Calcular estadísticas simuladas (puedes reemplazar con datos reales)
    const indexed = Math.floor(data.length * 0.75); // 75% indexados
    const fbShared = Math.floor(data.length * 0.6); // 60% compartidos en FB
    const pending = data.length - indexed; // Pendientes

    $('#indexedPosts').text(indexed);
    $('#fbSharedPosts').text(fbShared);
    $('#pendingPosts').text(pending);

    // Actualizar la información de paginación
    $('#paginationTotal').text(data.length);
    $('#paginationEnd').text(Math.min(10, data.length));
}

// Función para generar las filas de la tabla
function generateTableRows(data) {
    let rowHTML = '';
    data.forEach(post => {
        console.log(post);

        const dateCreated = formatDate(post.date);
        const titleLink =
            `<a href="${post.permalink}" target="_blank" class="text-blue-600 hover:text-blue-900 transition-colors duration-300">${post.title}</a>`;

        // Determinar si el post ya está indexado
        const blogData = window.blog || [];
        const isIndexed = Array.isArray(blogData) ? blogData.some(blogPost => blogPost && blogPost.posts === post.permalink) : false;

        // Determinar el estado de indexación
        const indexedStatus = isIndexed ?
            `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Indexed</span>` :
            post.status === 'publish' ?
                `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Posted</span>` :
                post.status === 'future' ?
                    `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Scheduled</span>` :
                    `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>`;

        rowHTML += `
            <tr class="hover:bg-blue-50 transition-colors duration-300">
                <!-- Título -->
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                            ${titleLink}
                        </div>
                    </div>
                </td>
    
                <!-- Estado de Indexación -->
                <td class="px-6 py-4 whitespace-nowrap">
                    ${indexedStatus}
                </td>
    
                <!-- PR (simulado) -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${Math.floor(Math.random() * 6) + 1}
                </td>
    
                <!-- Fecha de Creación -->
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${dateCreated}
                </td>
    
                <!-- Acciones -->
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-1">
                        <button title="Preview" onclick="window.open('${post.permalink}', '_blank')"
                            class="text-indigo-600 hover:text-indigo-900 transition-colors duration-300 p-2 rounded-full hover:bg-indigo-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
    
                        <button title="Change Status" onclick="openStatusModal(${post.id}, '${post.status}')"
                            class="text-purple-600 hover:text-purple-900 transition-colors duration-300 p-2 rounded-full hover:bg-purple-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
    
                        <button title="Delete" onclick="deletePost(${post.id})"
                            class="text-red-600 hover:text-red-900 transition-colors duration-300 p-2 rounded-full hover:bg-red-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
    
                        ${post.status === 'publish' && !isIndexed ? `
                            <button title="Submit to Index" onclick="openSubmitToIndexModal(${post.id}, '${post.permalink}')"
                                class="text-green-600 hover:text-green-900 transition-colors duration-300 p-2 rounded-full hover:bg-green-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>` : ''}
                    </div>
                </td>
            </tr>
        `;
    });

    return rowHTML;
}


function deletePost(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${window.website}/wp-json/limo-blogs/v1/delete-post/${postId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        Swal.fire(
                            'Deleted!',
                            'Post has been deleted.',
                            'success'
                        );
                        initializeApp(); // Refresh the table
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Error!',
                        'Failed to delete post.',
                        'error'
                    );
                    console.error('Error:', error);
                });
        }
    });
}

function openStatusModal(postId, currentStatus) {
    Swal.fire({
        title: 'Update Post Status',
        html: `
            <select id="postStatus" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="draft" ${currentStatus === 'draft' ? 'selected' : ''}>Draft</option>
                <option value="publish" ${currentStatus === 'publish' ? 'selected' : ''}>Published</option>
                <option value="private" ${currentStatus === 'private' ? 'selected' : ''}>Private</option>
            </select>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const newStatus = document.getElementById('postStatus').value;
            return fetch(`${window.website}/wp-json/limo-blogs/v1/update-status/${postId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    return data;
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Success!',
                text: 'Post status updated successfully',
                icon: 'success'
            });
            initializeApp(); // Refresh the table
        }
    });
}

// Función para inicializar la aplicación
function initializeApp() {


    if (!window.website) {
        showNoData("Error: Website is missing from the URL.");
        return; // Ahora esto es válido porque está dentro de una función
    }

    // Mostrar el spinner de carga
    $('#loadingSpinner').removeClass('hidden');
    $('#blogPostsTable').addClass('hidden');

    // Llamada AJAX para obtener las publicaciones del blog
    $.ajax({
        url: window.website + '/wp-json/limo-blogs/v1/get-posts',
        type: 'GET',
        timeout: 10000, // Timeout de 10 segundos
        success: function (data) {
            $('#loadingSpinner').addClass('hidden');

            if (!data || data.length === 0) {
                showNoData("No blog posts available. Create your first post to get started!");
                return;
            }

            // Mostrar la tabla y actualizar estadísticas
            $('#blogPostsTable').removeClass('hidden');
            updateStatistics(data);

            // Generar y mostrar las filas de la tabla
            $('#postsTable').html(generateTableRows(data));
        },
        error: function (error) {
            $('#loadingSpinner').addClass('hidden');
            showNoData("Error loading blog posts. Please try again later.");
            console.error("Error fetching posts:", error);
        }
    });
}

// Inicializar la aplicación cuando el documento esté listo
$(document).ready(function () {
    initializeApp();
});
let currentPostId = null;
let currentPostUrl = null;

function openSubmitToIndexModal(postId, postUrl) {
    currentPostId = postId;
    currentPostUrl = postUrl;
    const modal = document.getElementById('submitToIndexModal');
    modal.classList.remove('hidden');

    // Add opacity transition
    setTimeout(() => {
        modal.classList.add('opacity-100');

        // Animate the modal container
        const container = modal.querySelector('div');
        container.classList.add('scale-100');
        container.classList.remove('scale-95');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('submitToIndexModal');

    // Animate out
    modal.classList.remove('opacity-100');
    const container = modal.querySelector('div');
    container.classList.add('scale-95');
    container.classList.remove('scale-100');

    // Hide after animation completes
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

document.getElementById('submitIndexBtn').addEventListener('click', function () {
    const campaignName = document.getElementById('campaignName').value;
    if (campaignName && currentPostUrl) {
        submitToIndex(currentPostId, currentPostUrl, campaignName);
    } else {
        // Enhanced error feedback
        const input = document.getElementById('campaignName');
        input.classList.add('border-red-500', 'ring-1', 'ring-red-500');

        // Add error message
        if (!document.getElementById('error-message')) {
            const errorMessage = document.createElement('p');
            errorMessage.id = 'error-message';
            errorMessage.className = 'text-red-500 text-xs mt-1';
            errorMessage.innerText = 'Please enter a campaign name.';
            input.parentNode.appendChild(errorMessage);

            // Remove error styling after user starts typing
            input.addEventListener('input', function () {
                input.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                const error = document.getElementById('error-message');
                if (error) error.remove();
            }, { once: true });
        }
    }
});

function submitToIndex(postId, postUrl, campaignName) {
    const url = submitUrlRoute;
    const data = {
        postId: postId,
        urls: [postUrl],
        campaign: campaignName,
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verifica la respuesta en la consola
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    html: `
                    <p>${data.message}</p>
                    ${data.data.report_url ? `<p>Report: <a href="${data.data.report_url}" target="_blank" class="text-blue-500 hover:text-blue-700">View Report</a></p>` : ''}
                `,
                    confirmButtonText: 'OK',
                }).then(() => {
                    closeModal(); // Cerrar el modal después de confirmar
                    initializeApp(); // Actualizar la tabla y las estadísticas
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                    confirmButtonText: 'OK',
                });
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while submitting the request.',
                confirmButtonText: 'OK',
            });
        });
}