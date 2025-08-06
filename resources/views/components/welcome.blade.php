<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-white">
                    <h1 class="text-3xl font-bold mb-2">
                        Welcome, {{ Auth::user()->name  }}!
                    </h1>
                    <p class="text-blue-100 text-lg">
                        Your control center for managing your business
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all duration-300 backdrop-blur-sm">
                            <span class="font-medium">Quick Actions</span>
                            <svg class="ml-2 h-5 w-5 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg z-10 overflow-hidden">
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-150">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                New Client
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-150">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                New Post
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-150">
                                <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Upload Image
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Active Clients Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Clients</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ isset($clients) ? $clients->count() : 0 }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Total Clients</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-2 bg-blue-500 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Tasks</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ isset($tasks) ? $tasks->count() : 0 }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Pending: {{ isset($tasks) ? $tasks->where('status', 'pending')->count() : 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-2 bg-blue-500 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
            </div>

            <!-- Blog Posts Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Blog Posts</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ isset($blogs) ? $blogs->count() : 0 }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Total Posts</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-2 bg-blue-500 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
            </div>

            <!-- Completion Rate Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Task Completion</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">
                            @php
                                $totalTasks = isset($tasks) ? $tasks->count() : 0;
                                $completedTasks = isset($tasks) ? $tasks->filter(function($task) {
                                    return $task->status === 'completed';
                                })->count() : 0;
                                $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                            @endphp
                            {{ $completionRate }}%
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Success Rate</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="h-2 bg-gray-100 rounded-full">
                        <div class="h-2 bg-blue-500 rounded-full" style="width: {{ $completionRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Task Status Distribution -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Task Status Distribution</h2>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-lg">Overview</button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="taskDistributionChart"></canvas>
                </div>
            </div>

            <!-- Content Overview -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Content Overview</h2>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-lg">Statistics</button>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="contentOverviewChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Upcoming Tasks -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Activity</h2>
                <div class="space-y-4">
                    @if(isset($tasks) && $tasks->count() > 0)
                        @foreach($tasks->take(3) as $task)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl transition-all duration-200 hover:shadow-md">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $task->title ?? 'Untitled Task' }}</h3>
                                <p class="text-sm text-gray-500">{{ $task->description ?? 'No description available' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">{{ isset($task->created_at) ? $task->created_at->diffForHumans() : 'Recently' }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($task->status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-center justify-center p-8 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">No recent activity to display</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Upcoming Tasks -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Upcoming Tasks</h2>
                <div class="space-y-4">
                    @if(isset($tasks) && $tasks->where('status', 'pending')->count() > 0)
                        @foreach($tasks->where('status', 'pending')->take(3) as $task)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl transition-all duration-200 hover:shadow-md">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $task->title ?? 'Untitled Task' }}</h3>
                                <p class="text-sm text-gray-500">Due: {{ isset($task->due_date) ? $task->due_date->format('M d, Y') : 'No due date' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ isset($task->due_date) ? $task->due_date->diffForHumans() : 'No due date' }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Pending
                                </span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-center justify-center p-8 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">No upcoming tasks to display</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Common chart configuration
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#374151',
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#FFFFFF',
                        titleColor: '#374151',
                        bodyColor: '#374151',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        padding: 12,
                        boxPadding: 6,
                        usePointStyle: true
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            };

            // Check if elements exist before creating charts
            const taskDistributionCtx = document.getElementById('taskDistributionChart');
            const contentOverviewCtx = document.getElementById('contentOverviewChart');

            if (taskDistributionCtx) {
                // Task Distribution Chart (Doughnut)
                const pendingTasks = {{ isset($tasks) ? $tasks->filter(function($task) { return $task->status === 'pending'; })->count() : 0 }};
                const inProgressTasks = {{ isset($tasks) ? $tasks->filter(function($task) { return $task->status === 'in_progress'; })->count() : 0 }};
                const completedTasks = {{ isset($tasks) ? $tasks->filter(function($task) { return $task->status === 'completed'; })->count() : 0 }};
                
                // If there's no data, show placeholder data
                const taskData = [pendingTasks, inProgressTasks, completedTasks];
                const noTaskData = taskData.every(value => value === 0);
                
                const taskDistributionChart = new Chart(taskDistributionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'In Progress', 'Completed'],
                        datasets: [{
                            data: noTaskData ? [1, 1, 1] : taskData, // Use placeholder if no data
                            backgroundColor: [
                                'rgba(37, 99, 235, 0.7)',  // Blue for pending
                                'rgba(59, 130, 246, 0.7)', // Lighter blue for in progress
                                'rgba(96, 165, 250, 0.7)'  // Lightest blue for completed
                            ],
                            borderColor: [
                                'rgb(37, 99, 235)',
                                'rgb(59, 130, 246)',
                                'rgb(96, 165, 250)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        ...commonOptions,
                        cutout: '60%',
                        plugins: {
                            ...commonOptions.plugins,
                            tooltip: {
                                ...commonOptions.plugins.tooltip,
                                callbacks: {
                                    label: function(context) {
                                        if (noTaskData) {
                                            return 'No data available';
                                        }
                                        const label = context.label || '';
                                        const value = context.raw;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            },
                            // Add a center text for no data case
                            ...( noTaskData ? {
                                afterDraw: function(chart) {
                                    const ctx = chart.ctx;
                                    const width = chart.width;
                                    const height = chart.height;
                                    ctx.restore();
                                    ctx.font = "14px 'Inter', sans-serif";
                                    ctx.textBaseline = "middle";
                                    ctx.fillStyle = "#9CA3AF";
                                    ctx.textAlign = "center";
                                    ctx.fillText("No data available", width / 2, height / 2);
                                    ctx.save();
                                }
                            } : {})
                        }
                    }
                });
            }

            if (contentOverviewCtx) {
                // Content Overview Chart (Bar)
                const clientCount = {{ isset($clients) ? $clients->count() : 0 }};
                const blogCount = {{ isset($blogs) ? $blogs->count() : 0 }};
                const taskCount = {{ isset($tasks) ? $tasks->count() : 0 }};
                
                // If there's no data, show placeholder data
                const contentData = [clientCount, blogCount, taskCount];
                const noContentData = contentData.every(value => value === 0);
                
                const contentOverviewChart = new Chart(contentOverviewCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Clients', 'Blog Posts', 'Tasks'],
                        datasets: [{
                            label: 'Total Count',
                            data: contentData,
                            backgroundColor: [
                                'rgba(37, 99, 235, 0.7)',  // Blue for clients
                                'rgba(59, 130, 246, 0.7)', // Lighter blue for blogs
                                'rgba(96, 165, 250, 0.7)'  // Lightest blue for tasks
                            ],
                            borderColor: [
                                'rgb(37, 99, 235)',
                                'rgb(59, 130, 246)',
                                'rgb(96, 165, 250)'
                            ],
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        ...commonOptions,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#374151',
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 12
                                    },
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#374151',
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 12
                                    }
                                }
                            }
                        },
                        plugins: {
                            ...commonOptions.plugins,
                            // Add a center text for no data case
                            ...( noContentData ? {
                                afterDraw: function(chart) {
                                    const ctx = chart.ctx;
                                    const width = chart.width;
                                    const height = chart.height;
                                    ctx.restore();
                                    ctx.font = "14px 'Inter', sans-serif";
                                    ctx.textBaseline = "middle";
                                    ctx.fillStyle = "#9CA3AF";
                                    ctx.textAlign = "center";
                                    ctx.fillText("No data available", width / 2, height / 2);
                                    ctx.save();
                                }
                            } : {})
                        }
                    }
                });
            }
        });
    </script>
@endpush