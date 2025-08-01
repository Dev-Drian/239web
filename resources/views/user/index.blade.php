<x-app-layout>
    <x-slot name="header">
        @include('components.header', ['name' => 'User Management'])
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50 to-white" x-data="userManagement()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-blue-100">


                <div class="p-6">
                    <!-- Button Area -->
                    <div class="mb-6 flex justify-end">
                        <button @click="openCreateModal()"
                            class="inline-flex items-center px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Create New User
                        </button>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="w-full table-auto">
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Name
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Email
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Role
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-100">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-blue-50 transition-colors duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $user->getRoleNames()->first() ?? 'No Role' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button
                                                    @click="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->getRoleNames()->first() }}')"
                                                    class="inline-flex items-center p-2 rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:text-blue-800 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button @click="deleteUser({{ $user->id }})"
                                                    class="inline-flex items-center p-2 rounded-md text-red-700 bg-red-50 hover:bg-red-100 hover:text-red-800 transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Alert -->
        <div x-show="showError" x-cloak class="fixed top-4 right-4 z-[9999]"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-2"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-2">
            <div class="rounded-lg bg-red-50 p-4 shadow-lg border-l-4 border-red-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800" x-text="errorMessage"></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Modal -->
        <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-700 opacity-75" @click="closeCreateModal()"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-[10000]">
                    <form @submit.prevent="createUser">
                        <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-4 py-3">
                            <h3 class="text-lg leading-6 font-bold text-white">Create New User</h3>
                        </div>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Name</label>
                                <input type="text" x-model="newUser.name"
                                    class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Email</label>
                                <input type="email" x-model="newUser.email"
                                    class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Password</label>
                                <input type="password" x-model="newUser.password"
                                    class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Role</label>
                                <select x-model="newUser.role" class="mt-1 block w-full..." required>
                                    <option value="">Select a role</option>
                                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="bg-blue-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-700 text-base font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                Create
                            </button>
                            <button type="button" @click="closeCreateModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-blue-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-blue-700 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-700 opacity-75" @click="showEditModal = false"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-[10000]">
                    <form @submit.prevent="updateUser">
                        <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-4 py-3">
                            <h3 class="text-lg leading-6 font-bold text-white">Edit User</h3>
                        </div>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Name</label>
                                <input type="text" x-model="editUserData.name"
                                    class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Email</label>
                                <input type="email" x-model="editUserData.email"
                                    class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Password (leave blank to keep
                                    current)</label>
                                <input type="password" x-model="editUserData.password"
                                    class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-blue-800">Role</label>
                                <select x-model="editUserData.role"
                                    class="mt-1 block w-full rounded-md border-blue-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    required>
                                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="bg-blue-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-700 text-base font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                Update
                            </button>
                            <button type="button" @click="showEditModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-blue-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-blue-700 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-700 opacity-75" @click="showDeleteModal = false"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-[10000]">
                    <div class="bg-gradient-to-r from-red-600 to-red-500 px-4 py-3">
                        <h3 class="text-lg leading-6 font-bold text-white">Confirm Delete</h3>
                    </div>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete User</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Are you sure you want to delete this user? This
                                        action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="confirmDelete"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button @click="showDeleteModal = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function userManagement() {
            return {
                showCreateModal: false,
                showEditModal: false,
                showDeleteModal: false,
                deleteUserId: null,
                newUser: {
                    name: '',
                    email: '',
                    password: '',
                    role: ''
                },
                editUserData: {
                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    role: ''
                },
                errorMessage: '',
                showError: false,
                openCreateModal() {
                    this.newUser = {
                        name: '',
                        email: '',
                        password: '',
                        role: ''
                    };
                    this.errorMessage = '';
                    this.showError = false;
                    this.showCreateModal = true;
                },
                closeCreateModal() {
                    this.newUser = {
                        name: '',
                        email: '',
                        password: '',
                        role: ''
                    };
                    this.errorMessage = '';
                    this.showError = false;
                    this.showCreateModal = false;
                },
                editUser(id, name, email, role) {
                    this.editUserData = {
                        id,
                        name,
                        email,
                        password: '',
                        role
                    };
                    this.errorMessage = '';
                    this.showError = false;
                    this.showEditModal = true;
                },
                deleteUser(id) {
                    this.deleteUserId = id;
                    this.showDeleteModal = true;
                },
                async createUser() {
                    try {
                        const response = await fetch('{{ route('users.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.newUser)
                        });
                        const data = await response.json();

                        if (data.success) {
                            this.closeCreateModal();
                            window.location.reload();
                        } else {
                            // Handle validation errors
                            if (data.errors) {
                                const errorMessages = [];
                                for (const field in data.errors) {
                                    errorMessages.push(data.errors[field][0]);
                                }
                                this.errorMessage = errorMessages.join(' ');
                            } else {
                                this.errorMessage = data.message || 'Error creating user';
                            }
                            this.showError = true;
                        }
                    } catch (error) {
                        this.errorMessage = 'Error creating user. Please try again.';
                        this.showError = true;
                        console.error('Error:', error);
                    }
                },
                async updateUser() {
                    try {
                        const response = await fetch(`{{ route('users.update', '') }}/${this.editUserData.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.editUserData)
                        });
                        const data = await response.json();

                        if (data.success) {
                            this.showEditModal = false;
                            window.location.reload();
                        } else {
                            // Handle validation errors
                            if (data.errors) {
                                const errorMessages = [];
                                for (const field in data.errors) {
                                    errorMessages.push(data.errors[field][0]);
                                }
                                this.errorMessage = errorMessages.join(' ');
                            } else {
                                this.errorMessage = data.message || 'Error updating user';
                            }
                            this.showError = true;
                        }
                    } catch (error) {
                        this.errorMessage = 'Error updating user. Please try again.';
                        this.showError = true;
                        console.error('Error:', error);
                    }
                },
                async confirmDelete() {
                    try {
                        const response = await fetch(`{{ route('users.destroy', '') }}/${this.deleteUserId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        const data = await response.json();

                        if (data.success) {
                            this.showDeleteModal = false;
                            window.location.reload();
                        } else {
                            this.errorMessage = data.message || 'Error deleting user';
                            this.showError = true;
                        }
                    } catch (error) {
                        this.errorMessage = 'Error deleting user. Please try again.';
                        this.showError = true;
                        console.error('Error:', error);
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-app-layout>
