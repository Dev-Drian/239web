<script>
    // Global utility functions for blog management
    window.blogUtils = {
        // Alert system
        showAlert: function(type, message, duration = 5000) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.blog-alert');
            existingAlerts.forEach(alert => alert.remove());

            const alertTypes = {
                success: {
                    bg: 'bg-gradient-to-r from-green-500/20 to-emerald-500/20',
                    border: 'border-green-500/30',
                    icon: `<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>`,
                    text: 'text-green-300'
                },
                error: {
                    bg: 'bg-gradient-to-r from-red-500/20 to-pink-500/20',
                    border: 'border-red-500/30',
                    icon: `<svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>`,
                    text: 'text-red-300'
                },
                warning: {
                    bg: 'bg-gradient-to-r from-yellow-500/20 to-orange-500/20',
                    border: 'border-yellow-500/30',
                    icon: `<svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>`,
                    text: 'text-yellow-300'
                },
                info: {
                    bg: 'bg-gradient-to-r from-blue-500/20 to-indigo-500/20',
                    border: 'border-blue-500/30',
                    icon: `<svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>`,
                    text: 'text-blue-300'
                }
            };

            const alertConfig = alertTypes[type] || alertTypes.info;

            const alertElement = document.createElement('div');
            alertElement.className =
                `blog-alert fixed top-4 right-4 z-50 glass-card ${alertConfig.bg} ${alertConfig.border} border backdrop-blur-xl rounded-xl p-4 shadow-2xl transform translate-x-full transition-all duration-300 ease-out max-w-md`;

            alertElement.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        ${alertConfig.icon}
                    </div>
                    <div class="flex-1">
                        <p class="${alertConfig.text} text-sm font-medium">${message}</p>
                    </div>
                    <button class="flex-shrink-0 text-slate-400 hover:text-slate-300 transition-colors duration-200" onclick="this.parentElement.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(alertElement);

            // Animate in
            setTimeout(() => {
                alertElement.classList.remove('translate-x-full');
                alertElement.classList.add('translate-x-0');
            }, 100);

            // Auto remove
            if (duration > 0) {
                setTimeout(() => {
                    alertElement.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (alertElement.parentNode) {
                            alertElement.remove();
                        }
                    }, 300);
                }, duration);
            }
        },

        // Spinner functions
        showSpinner: function(spinnerId) {
            const spinner = document.getElementById(spinnerId);
            if (spinner) {
                spinner.classList.remove('hidden');
            } else {
                console.warn(`Spinner element with id '${spinnerId}' not found`);
            }
        },

        hideSpinner: function(spinnerId) {
            const spinner = document.getElementById(spinnerId);
            if (spinner) {
                spinner.classList.add('hidden');
            } else {
                console.warn(`Spinner element with id '${spinnerId}' not found`);
            }
        },

        // CSRF Token
        getCsrfToken: function() {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                document.querySelector('input[name="_token"]')?.value;
            if (!token) {
                console.error('CSRF token not found');
            }
            return token;
        },

        // Loading spinner
        showGlobalLoader: function(message = 'Loading...') {
            const existingLoader = document.getElementById('globalLoader');
            if (existingLoader) {
                existingLoader.remove();
            }

            const loader = document.createElement('div');
            loader.id = 'globalLoader';
            loader.className =
            'fixed inset-0 z-50 flex items-center justify-center glass-card backdrop-blur-xl';

            loader.innerHTML = `
                <div class="glass-card p-8 rounded-2xl border border-white/10 shadow-2xl">
                    <div class="flex flex-col items-center space-y-4">
                        <div class="loading-spinner-large"></div>
                        <p class="text-white font-medium">${message}</p>
                    </div>
                </div>
            `;

            document.body.appendChild(loader);

            // Animate in
            setTimeout(() => {
                loader.classList.add('opacity-100');
            }, 100);
        },

        hideGlobalLoader: function() {
            const loader = document.getElementById('globalLoader');
            if (loader) {
                loader.classList.add('opacity-0');
                setTimeout(() => {
                    if (loader.parentNode) {
                        loader.remove();
                    }
                }, 300);
            }
        },

        // Toast notifications
        showToast: function(message, type = 'info', duration = 3000) {
            this.showAlert(type, message, duration);
        },

        // Confirmation dialog
        showConfirm: function(title, message, onConfirm, onCancel) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 flex items-center justify-center glass-card backdrop-blur-xl';

            modal.innerHTML = `
                <div class="glass-card p-6 rounded-2xl border border-white/10 shadow-2xl max-w-md w-full mx-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">${title}</h3>
                    </div>
                    <p class="text-slate-300 mb-6">${message}</p>
                    <div class="flex justify-end space-x-3">
                        <button id="cancelBtn" class="btn-ghost">Cancel</button>
                        <button id="confirmBtn" class="btn-primary">Confirm</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            const cancelBtn = modal.querySelector('#cancelBtn');
            const confirmBtn = modal.querySelector('#confirmBtn');

            cancelBtn.addEventListener('click', () => {
                modal.remove();
                if (onCancel) onCancel();
            });

            confirmBtn.addEventListener('click', () => {
                modal.remove();
                if (onConfirm) onConfirm();
            });

            // Close on backdrop click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.remove();
                    if (onCancel) onCancel();
                }
            });
        },

        // Form validation
        validateForm: function(formId, rules) {
            const form = document.getElementById(formId);
            if (!form) return false;

            let isValid = true;
            const errors = [];

            Object.keys(rules).forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                const rule = rules[fieldName];

                if (!field) return;

                // Remove existing error styling
                field.classList.remove('border-red-500/50', 'focus:border-red-500',
                    'focus:ring-red-500/20');

                // Required validation
                if (rule.required && (!field.value || field.value.trim() === '')) {
                    isValid = false;
                    errors.push(`${rule.label || fieldName} is required`);
                    field.classList.add('border-red-500/50', 'focus:border-red-500',
                        'focus:ring-red-500/20');
                }

                // Min length validation
                if (rule.minLength && field.value.length < rule.minLength) {
                    isValid = false;
                    errors.push(
                        `${rule.label || fieldName} must be at least ${rule.minLength} characters`);
                    field.classList.add('border-red-500/50', 'focus:border-red-500',
                        'focus:ring-red-500/20');
                }

                // Max length validation
                if (rule.maxLength && field.value.length > rule.maxLength) {
                    isValid = false;
                    errors.push(
                        `${rule.label || fieldName} must be no more than ${rule.maxLength} characters`
                        );
                    field.classList.add('border-red-500/50', 'focus:border-red-500',
                        'focus:ring-red-500/20');
                }

                // Email validation
                if (rule.email && field.value) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(field.value)) {
                        isValid = false;
                        errors.push(`${rule.label || fieldName} must be a valid email address`);
                        field.classList.add('border-red-500/50', 'focus:border-red-500',
                            'focus:ring-red-500/20');
                    }
                }
            });

            if (!isValid) {
                this.showAlert('error', errors.join('<br>'));
            }

            return isValid;
        },

        // Local storage helpers
        saveToStorage: function(key, data) {
            try {
                localStorage.setItem(`blog_${key}`, JSON.stringify(data));
            } catch (error) {
                console.error('Error saving to localStorage:', error);
            }
        },

        getFromStorage: function(key) {
            try {
                const data = localStorage.getItem(`blog_${key}`);
                return data ? JSON.parse(data) : null;
            } catch (error) {
                console.error('Error reading from localStorage:', error);
                return null;
            }
        },

        removeFromStorage: function(key) {
            try {
                localStorage.removeItem(`blog_${key}`);
            } catch (error) {
                console.error('Error removing from localStorage:', error);
            }
        },

        // Auto-save functionality
        setupAutoSave: function(formId, interval = 30000) {
            const form = document.getElementById(formId);
            if (!form) return;

                const autoSave = () => {
                    const formData = new FormData(form);
                    const data = {};

                    for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }

                // Add editor content if available
                if (window.editorInstance) {
                    data.content = window.editorInstance.getData();
                }

                this.saveToStorage('autosave', {
                    data: data,
                    timestamp: Date.now()
                });

                this.showToast('Draft saved automatically', 'info', 2000);
            };

            // Save every interval
            setInterval(autoSave, interval);

            // Save on form change
            form.addEventListener('input', () => {
                clearTimeout(this.autoSaveTimeout);
                this.autoSaveTimeout = setTimeout(autoSave, 5000);
            });
        },

        // Restore auto-saved data
        restoreAutoSave: function(formId) {
            const savedData = this.getFromStorage('autosave');
            if (!savedData) return false;

            const form = document.getElementById(formId);
            if (!form) return false;

            // Check if data is recent (within 24 hours)
            const isRecent = (Date.now() - savedData.timestamp) < (24 * 60 * 60 * 1000);
            if (!isRecent) return false;

            this.showConfirm(
                'Restore Draft',
                'We found an auto-saved draft from your previous session. Would you like to restore it?',
                () => {
                    // Restore form data
                    Object.keys(savedData.data).forEach(key => {
                        const field = form.querySelector(`[name="${key}"]`);
                        if (field && key !== 'content') {
                            field.value = savedData.data[key];
                        }
                    });

                    // Restore editor content
                    if (savedData.data.content && window.editorInstance) {
                        window.editorInstance.setData(savedData.data.content);
                    }

                    this.showAlert('success', 'Draft restored successfully!');
                    this.removeFromStorage('autosave');
                },
                () => {
                    this.removeFromStorage('autosave');
                }
            );

            return true;
        }
    };

    // Make functions globally available
    window.showAlert = window.blogUtils.showAlert.bind(window.blogUtils);
    window.showToast = window.blogUtils.showToast.bind(window.blogUtils);
    window.showConfirm = window.blogUtils.showConfirm.bind(window.blogUtils);
    window.showGlobalLoader = window.blogUtils.showGlobalLoader.bind(window.blogUtils);
    window.hideGlobalLoader = window.blogUtils.hideGlobalLoader.bind(window.blogUtils);
    window.showSpinner = window.blogUtils.showSpinner.bind(window.blogUtils);
    window.hideSpinner = window.blogUtils.hideSpinner.bind(window.blogUtils);
    window.getCsrfToken = window.blogUtils.getCsrfToken.bind(window.blogUtils);

    // Variables globales compartidas
    let imageUrl = null;

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-save functionality disabled
        // window.blogUtils.setupAutoSave('contentForm');
        // window.blogUtils.restoreAutoSave('contentForm');
    });
</script>
