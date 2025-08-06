    <x-app-layout>
        <x-slot name="header">
            @include('components.header', ['name' => 'Blog'])
        </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div
                    class="glass-dark overflow-hidden shadow-sm rounded-lg transition-all duration-300 hover:shadow-md border border-white/15">
                    <div class="p-6 flex items-center">
                        <div class="p-3 rounded-full bg-indigo-500/20 mr-4">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-slate-300">Total Clients</div>
                            <div class="text-2xl font-semibold text-white">{{ $clients->count() }}</div>
                        </div>
                    </div>
                </div>
                <div
                    class="glass-dark overflow-hidden shadow-sm rounded-lg transition-all duration-300 hover:shadow-md border border-white/15">
                    <div class="p-6 flex items-center">
                        <div class="p-3 rounded-full bg-green-500/20 mr-4">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-slate-300">Active Clients</div>
                            <div class="text-2xl font-semibold text-white">
                                {{ $clients->where('status', 'active')->count() }}</div>
                        </div>
                    </div>
                </div>
                <div
                    class="glass-dark overflow-hidden shadow-sm rounded-lg transition-all duration-300 hover:shadow-md border border-white/15">
                    <div class="p-6 flex items-center">
                        <div class="p-3 rounded-full bg-purple-500/20 mr-4">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-slate-300">Blogs This Month</div>
                            <div class="text-2xl font-semibold text-white">0</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div
                class="glass-dark overflow-hidden shadow-xl sm:rounded-lg mt-8 transition-all duration-300 hover:shadow-lg border border-white/15">
                <div class="p-6 sm:px-8 glass-dark border-b border-white/15">
                    <!-- Filters and Search -->
                    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <form method="GET" action="{{ route('blog.index') }}"
                            class="flex-1 flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" placeholder="Search by name, email or ID..."
                                    class="pl-10 w-full px-4 py-2.5 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300">
                            </div>
                            <button type="submit"
                                class="px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-medium rounded-lg transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                Search
                            </button>
                        </form>

                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-slate-600 rounded-full peer peer-checked:bg-indigo-500 peer-focus:ring-2 peer-focus:ring-indigo-500/50 transition-all duration-300">
                                    </div>
                                    <div
                                        class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:left-6 transition-all duration-300">
                                    </div>
                                </div>
                                <span
                                    class="text-sm text-slate-300 group-hover:text-white transition-all duration-300">Show
                                    inactive clients</span>
                            </label>
                        </div>
                    </div>

                    <!-- Client List -->
                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-white/15">
                            <thead class="glass-dark">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                        Website</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                        Blog</th> <!-- Nueva columna -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                        Last Blog</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="glass-dark divide-y divide-white/15">
                                @foreach ($clients as $client)
                                    <tr class="hover:bg-white/5 transition-colors duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 overflow-hidden rounded-full border-2 border-white/20 bg-slate-700 transition-all duration-300 hover:border-indigo-500">
                                                    <img class="h-full w-full object-cover" src="{{ $client->avatar }}"
                                                        alt="{{ $client->name }}"
                                                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($client->name) }}&color=7F9CF5&background=EBF4FF'">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-white">
                                                        {{ $client->name }}</div>
                                                    <div class="text-sm text-slate-300">{{ $client->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ $client->website }}" target="_blank"
                                                class="text-indigo-400 hover:text-indigo-300 hover:underline transition-colors duration-300 flex items-center gap-1">
                                                {{ $client->website }}
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span id="blog-status-{{ $client->id }}"
                                                class="text-sm text-slate-300">Checking...</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-300 transition-all duration-300 hover:bg-green-500/30">
                                                3 days ago
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-1">
                                                <form action="{{ route('blog.show', $client->highlevel_id) }}">
                                                    <button title="View Blog" type="submit"
                                                        class="text-indigo-400 hover:text-indigo-300 transition-colors duration-300 p-2 rounded-full hover:bg-indigo-500/10">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <button title="Select Link" onclick="fetchPages({{ $client }})"
                                                    class="text-yellow-400 hover:text-yellow-300 transition-colors duration-300 p-2 rounded-full hover:bg-yellow-500/10">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                </button>
                                                {{-- <button title="Create New Blog"
                                                    class="text-green-400 hover:text-green-300 transition-colors duration-300 p-2 rounded-full hover:bg-green-500/10">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                    </svg>
                                                </button> --}}

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{-- {{ $clients->links() }} --}}
                        <nav class="flex items-center justify-between">
                            {{ $clients->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Creation Modal -->
        <div id="clientModal"
            class="fixed inset-0 z-50 overflow-y-auto hidden bg-black bg-opacity-50 transition-opacity duration-300">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div id="modalContent"
                    class="inline-block align-bottom glass-dark rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full opacity-0 scale-95 duration-300 border border-white/15">
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button type="button" onclick="closeModal()"
                            class="text-slate-400 hover:text-white focus:outline-none">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="glass-dark px-4 pt-5 pb-4 sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-white">Select Pages</h3>
                                <div class="mt-4">
                                    <form id="pageForm">

                                        <div id="checkboxContainer" class="mt-2"></div>
                                        <div class="mt-5 sm:mt-6">
                                            <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-base font-medium text-white hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                                                Save Selection
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function fetchPages(client) {
                const website = client.website?.replace(/\/$/, '');
                const highlevelId = client.highlevel_id;
                const selectedPages = client.selected_pages || [];
                const checkboxContainer = document.getElementById("checkboxContainer");

                // Store highlevelId as a data attribute on the form
                document.getElementById("pageForm").setAttribute("data-highlevel", highlevelId);

                // Show modal with animation
                document.getElementById("clientModal").classList.remove("hidden");
                setTimeout(() => {
                    document.getElementById("modalContent").classList.add("scale-100", "opacity-100");
                }, 50);

                // Show loader while loading
                checkboxContainer.innerHTML = `
        <div class="flex justify-center items-center py-10">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-500"></div>
        </div>
    `;

                // Parse the selected pages once, outside of the AJAX call
                let selectedPageIds = parseSelectedPages(selectedPages);

                // Make AJAX request
                $.ajax({
                    url: `${website}/wp-json/limo-blogs/v1/get-pages`,
                    type: 'GET',
                    data: {
                        highlevelId
                    },
                    timeout: 10000,
                    success: function(data) {
                        renderPageList(data, selectedPageIds);
                        setupFormHandler(website, highlevelId);
                    },
                    error: function(error) {
                        handleFetchError(website, highlevelId, selectedPages, error);
                    }
                });
            }

            // Parse selected pages into a clean array of IDs
            function parseSelectedPages(selectedPages) {
                if (!selectedPages) return [];

                try {
                    // If it's a string, try to parse it
                    if (typeof selectedPages === 'string') {
                        try {
                            selectedPages = JSON.parse(selectedPages);
                        } catch (e) {
                            console.error('Error parsing selected pages string:', e);
                            return [];
                        }
                    }

                    // Handle different formats
                    if (Array.isArray(selectedPages)) {
                        return selectedPages.map(page => String(page.id || page.ID));
                    } else if (typeof selectedPages === 'object') {
                        return Object.values(selectedPages)
                            .map(page => String(page.id || page.ID));
                    }
                } catch (e) {
                    console.error('Error processing selectedPages:', e);
                }

                return [];
            }

            // Render the page list UI
            function renderPageList(data, selectedPageIds) {
                const checkboxContainer = document.getElementById("checkboxContainer");

                checkboxContainer.innerHTML = `
        <div class="mb-4 sticky top-0 glass-dark pt-2 pb-3 border-b border-white/15">
            <div class="relative">
                <input type="text" id="searchPages" placeholder="Search pages..." 
                    class="w-full px-4 py-2 glass border border-white/20 rounded-lg bg-transparent text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50"
                >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute right-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="flex justify-between mt-3">
                <button type="button" id="selectAll" class="text-sm text-indigo-400 hover:text-indigo-300">
                    Select all
                </button>
                <button type="button" id="deselectAll" class="text-sm text-indigo-400 hover:text-indigo-300">
                    Deselect all
                </button>
            </div>
        </div>
        <div id="pagesContainer" class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-60 overflow-y-auto pb-2"></div>
        <div class="mt-3 text-right text-sm text-slate-300">
            <span id="pageCount">0</span> of ${data.length} pages selected
        </div>
    `;

                const pagesContainer = document.getElementById("pagesContainer");

                // Add pages to container
                data.forEach(page => {
                    const pageId = String(page.ID);
                    const isSelected = selectedPageIds.includes(pageId);

                    const div = document.createElement("div");
                    div.classList.add("flex", "items-center", "p-2", "hover:bg-white/5", "rounded");

                    div.innerHTML = `
            <input type="checkbox" name="selectedPages[]" value="${page.ID}" 
                id="page-${page.ID}" 
                data-title="${page.title.toLowerCase()}" 
                data-url="${page.permalink || ''}" 
                class="h-4 w-4 text-indigo-500 border-white/30 rounded focus:ring-indigo-500/50 bg-transparent"
                ${isSelected ? 'checked' : ''}>
            <label for="page-${page.ID}" class="ml-2 text-slate-300 text-sm cursor-pointer truncate">
                ${page.title}
            </label>
        `;

                    pagesContainer.appendChild(div);
                });

                // Setup event listeners
                setupSearchAndSelectionHandlers();
                updateSelectedCount();
            }

            // Setup search and selection handlers
            function setupSearchAndSelectionHandlers() {
                // Implement search
                document.getElementById("searchPages").addEventListener("input", function(e) {
                    const searchText = e.target.value.toLowerCase();
                    const checkboxes = document.querySelectorAll('input[name="selectedPages[]"]');

                    checkboxes.forEach(checkbox => {
                        const title = checkbox.getAttribute("data-title");
                        const parentDiv = checkbox.parentElement;

                        parentDiv.classList.toggle("hidden", !title.includes(searchText));
                    });
                });

                // Implement select/deselect all
                document.getElementById("selectAll").addEventListener("click", function() {
                    const visibleCheckboxes = document.querySelectorAll(
                        'input[name="selectedPages[]"]'
                    );

                    visibleCheckboxes.forEach(checkbox => {
                        if (!checkbox.parentElement.classList.contains("hidden")) {
                            checkbox.checked = true;
                        }
                    });

                    updateSelectedCount();
                });

                document.getElementById("deselectAll").addEventListener("click", function() {
                    const checkboxes = document.querySelectorAll('input[name="selectedPages[]"]');
                    checkboxes.forEach(checkbox => checkbox.checked = false);
                    updateSelectedCount();
                });

                // Update counter when a checkbox changes
                const checkboxes = document.querySelectorAll('input[name="selectedPages[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener("change", updateSelectedCount);
                });
            }

            // Handle fetch error with SweetAlert
            function handleFetchError(website, highlevelId, selectedPages, error) {
                const checkboxContainer = document.getElementById("checkboxContainer");

                checkboxContainer.innerHTML = `
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <p class="text-red-400 text-base font-medium">Error loading pages</p>
            <p class="text-slate-300 text-sm mt-1">Please try again later</p>
            <button type="button" id="retryButton" class="mt-4 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:ring-offset-2">
                Retry
            </button>
        </div>
    `;

                document.getElementById("retryButton").addEventListener("click", function() {
                    fetchPages({
                        website: website,
                        highlevel_id: highlevelId,
                        selected_pages: selectedPages
                    });
                });

                console.error("Error fetching pages:", error);
            }

            // Function to update the counter
            function updateSelectedCount() {
                const selectedCount = document.querySelectorAll('input[name="selectedPages[]"]:checked').length;
                document.getElementById("pageCount").textContent = selectedCount;
            }

            // Setup the form submission handler
            function setupFormHandler(website, highlevelId) {
                const pageForm = document.getElementById("pageForm");

                // Remove any existing event listeners
                const clonedForm = pageForm.cloneNode(true);
                pageForm.parentNode.replaceChild(clonedForm, pageForm);

                // Add the event listener
                clonedForm.addEventListener("submit", function(event) {
                    event.preventDefault();

                    const selectedPages = document.querySelectorAll('input[name="selectedPages[]"]:checked');

                    if (selectedPages.length > 0) {
                        saveSelectedPages(website, highlevelId);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Pages Selected',
                            text: 'Please select at least one page.',
                            confirmButtonColor: '#6366f1',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                });
            }

            // Close the modal
            function closeModal() {
                // Closing animation
                const modalContent = document.getElementById("modalContent");
                modalContent.classList.remove("scale-100", "opacity-100");
                modalContent.classList.add("scale-95", "opacity-0");

                setTimeout(() => {
                    document.getElementById("clientModal").classList.add("hidden");
                    modalContent.classList.remove("scale-95", "opacity-0");
                }, 200);
            }

            // Save the selected pages
            function saveSelectedPages(website, highlevelId) {
                // Show loading state for button
                const submitButton = document.querySelector("#pageForm button[type='submit']");
                const originalButtonText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Saving...
    `;

                // Get selected pages with IDs and URLs
                const selectedPagesData = Array.from(document.querySelectorAll('input[name="selectedPages[]"]:checked'))
                    .map(checkbox => ({
                        id: checkbox.value,
                        ID: checkbox.value, // Both formats for compatibility
                        url: checkbox.getAttribute("data-url"),
                        title: checkbox.parentElement.querySelector('label').textContent
                    }));

                // AJAX to save selected pages
                $.ajax({
                    url: "{{ route('client.updateSelectPage', ':id') }}".replace(':id', highlevelId),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        highlevel_id: highlevelId,
                        pages: selectedPagesData
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        // Show success message with SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: `${selectedPagesData.length} pages saved successfully!`,
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });

                        // Close the modal
                        closeModal();
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                        // Reset the button
                        submitButton.innerHTML = originalButtonText;
                        submitButton.disabled = false;

                    },
                    error: function(error) {
                        // Show error with SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Could not save the selected pages. Please try again.',
                            confirmButtonColor: '#6366f1'
                        });

                        // Reset button
                        submitButton.innerHTML = originalButtonText;
                        submitButton.disabled = false;

                        console.error("Error saving pages:", error);
                    }
                });
            }

            // Set up global event listeners
            document.addEventListener('DOMContentLoaded', function() {
                // Close modal when clicking outside
                document.getElementById("clientModal").addEventListener("click", function(event) {
                    if (event.target === this) {
                        closeModal();
                    }
                });

                // Close with Escape key
                document.addEventListener("keydown", function(event) {
                    if (event.key === "Escape" && !document.getElementById("clientModal").classList.contains(
                            "hidden")) {
                        closeModal();
                    }
                });

                // Make sure SweetAlert is loaded
                if (typeof Swal === 'undefined') {
                    // Load SweetAlert if not available
                    const sweetAlertScript = document.createElement('script');
                    sweetAlertScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    document.head.appendChild(sweetAlertScript);
                }
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Convierte la respuesta de Laravel a JSON
                const paginationData = {!! json_encode($clients) !!};

                // Accede a la propiedad `data` que contiene el array de clientes
                const clients = paginationData.data;

                // Verifica que clients sea un array
                if (Array.isArray(clients)) {
                    clients.forEach(client => {
                        const blogStatusElement = document.getElementById(`blog-status-${client.id}`);

                        if (client.website) {
                            // Asegúrate de que la URL del sitio web sea válida
                            const websiteUrl = client.website.startsWith('http') ? client.website :
                                `https://${client.website}`;

                            // Hace la solicitud a la API
                            fetch(`${websiteUrl}/wp-json/limo-blogs/v1/get-posts`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    // Si hay datos y es un array, muestra la cantidad de blogs
                                    if (Array.isArray(data)) {
                                        blogStatusElement.textContent = data
                                            .length; // Muestra el número de blogs
                                    } else {
                                        blogStatusElement.textContent = '0'; // Si no es un array, muestra 0
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching blog data:', error);
                                    blogStatusElement.textContent = '0'; // Muestra 0 si hay un error
                                });
                        } else {
                            blogStatusElement.textContent = '0'; // Si no hay website, muestra 0
                        }
                    });
                } else {
                    console.error('Clients is not an array:', clients);
                }
            });
        </script>

        <script>
            function openModal() {
                const modal = document.getElementById('clientModal');
                const content = document.getElementById('modalContent');

                modal.classList.remove('hidden');
                // Give time for the display to update before animating
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            function closeModal() {
                const modal = document.getElementById('clientModal');
                const content = document.getElementById('modalContent');

                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300); // Match the duration of the transition
            }
        </script>
    </x-app-layout>
