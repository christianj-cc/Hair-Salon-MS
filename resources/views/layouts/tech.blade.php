@php use Illuminate\Support\Facades\Storage; @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hair Salon MS') }} - Beauty Tech</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Hide scrollbar for sidebar */
        .sidebar-nav {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE/Edge */
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
            /* Chrome/Safari/Opera */
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100" x-data="{
    sidebarExpanded: localStorage.getItem('sidebarExpanded') !== 'false'
}" x-init="$watch('sidebarExpanded', val => localStorage.setItem('sidebarExpanded', val))">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - collapsible width, always visible -->
        <div
            :class="sidebarExpanded ? 'w-64' : 'w-16'"
            class="flex-shrink-0 transition-all duration-300 ease-in-out overflow-hidden bg-white border-r border-gray-200 z-50">
            <div class="flex flex-col h-full">
                <!-- Logo area -->
                <div class="flex items-center justify-center px-4 transition-all duration-300 ease-in-out"
                    :class="sidebarExpanded ? 'h-28' : 'h-16'">
                    <template x-if="sidebarExpanded">
                        <div class="p-4 pb-1">
                            <a href="{{ route('tech.dashboard') }}">
                                <img src="{{ asset('storage/assets/Logo.png') }}" alt="Logo" class="w-full h-auto object-cover">
                            </a>
                        </div>
                    </template>
                    <template x-if="!sidebarExpanded">
                        <div class="p-0">
                            <a href="{{ route('tech.dashboard') }}">
                                <img src="{{ asset('storage/assets/L-logo-red.png') }}" alt="Logo" class="h-10 object-contain">
                            </a>
                        </div>
                    </template>
                </div>

                <nav class="sidebar-nav flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('tech.dashboard') }}"
                        :class="sidebarExpanded ? 'justify-start px-4' : 'justify-center px-2'"
                        class="flex items-center py-3 text-sm font-medium rounded-md whitespace-nowrap transition-all
                               {{ request()->routeIs('tech.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-6 h-6 flex-shrink-0" :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="sidebarExpanded" x-cloak>Dashboard</span>
                    </a>

                    <!-- My Appointments -->
                    <a href="{{ route('tech.appointments.index') }}"
                        :class="sidebarExpanded ? 'justify-start px-4' : 'justify-center px-2'"
                        class="flex items-center py-3 text-sm font-medium rounded-md whitespace-nowrap transition-all
                               {{ request()->routeIs('tech.appointments.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-6 h-6 flex-shrink-0" :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-show="sidebarExpanded" x-cloak>My Appointments</span>
                    </a>

                    <!-- Service History -->
                    <a href="{{ route('tech.history.index') }}"
                        :class="sidebarExpanded ? 'justify-start px-4' : 'justify-center px-2'"
                        class="flex items-center py-3 text-sm font-medium rounded-md whitespace-nowrap transition-all
                               {{ request()->routeIs('tech.history.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                        <svg class="w-6 h-6 flex-shrink-0" :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-show="sidebarExpanded" x-cloak>Service History</span>
                    </a>
                </nav>

                <!-- Bottom section (My Account & Logout) -->
                <div class="px-2 py-4 border-t border-gray-200 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        :class="sidebarExpanded ? 'justify-start px-4' : 'justify-center px-2'"
                        class="flex items-center py-3 text-sm font-medium rounded-md whitespace-nowrap transition-all
           {{ request()->routeIs('profile.*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                        <!-- Avatar circle with profile photo or initial -->
                        <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden
        {{ request()->routeIs('profile.*') ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600' }}"
                            :class="sidebarExpanded ? 'mr-3' : 'mr-0'">
                            @php
                            $user = Auth::user();
                            $profileImageUrl = null;
                            if ($user->role == 'customer' && $user->customer && $user->customer->image) {
                            if (Storage::disk('public')->exists($user->customer->image)) {
                            $profileImageUrl = asset('storage/' . $user->customer->image);
                            }
                            } elseif (in_array($user->role, ['admin', 'frontdesk', 'tech']) && $user->employee && $user->employee->image) {
                            if (Storage::disk('public')->exists($user->employee->image)) {
                            $profileImageUrl = asset('storage/' . $user->employee->image);
                            }
                            }
                            @endphp
                            @if($profileImageUrl)
                            <img src="{{ $profileImageUrl }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <span x-show="sidebarExpanded" x-cloak>My Account</span>
                    </a>
                    <button @click="confirmAction('Logout', 'Are you sure you want to log out?', '{{ route('logout') }}', 'POST', 'Logout')"
                        :class="sidebarExpanded ? 'justify-start px-4' : 'justify-center px-2'"
                        class="flex items-center w-full py-3 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-100 hover:text-gray-900 whitespace-nowrap transition-all">
                        <svg class="w-6 h-6 flex-shrink-0" :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span x-show="sidebarExpanded" x-cloak>Logout</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out">
            <header class="bg-gradient-to-r from-primary to-gradient text-white shadow-sm">
                <div class="flex items-center justify-between h-16 px-4">
                    <button @click="sidebarExpanded = !sidebarExpanded; localStorage.setItem('sidebarExpanded', sidebarExpanded)" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center">
                        <span class="text-sm text-white mr-4">{{ Auth::user()->name }}</span>
                        <a href="{{ route('profile.edit') }}">
                            @php
                            $user=Auth::user();
                            $profileImageUrl=null;
                            if ($user->role == 'customer' && $user->customer && $user->customer->image) {
                            if (Storage::disk('public')->exists($user->customer->image)) {
                            $profileImageUrl = asset('storage/' . $user->customer->image);
                            }
                            } elseif (in_array($user->role, ['admin', 'frontdesk', 'tech']) && $user->employee && $user->employee->image) {
                            if (Storage::disk('public')->exists($user->employee->image)) {
                            $profileImageUrl = asset('storage/' . $user->employee->image);
                            }
                            }
                            @endphp
                            @if($profileImageUrl)
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $profileImageUrl }}" alt="Profile">
                            @else
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" alt="Profile">
                            @endif
                        </a>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4">
                <!--@if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
                @endif-->
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('modal', {
                open: false,
                title: '',
                message: '',
                action: '',
                method: 'POST',
                buttonText: 'Confirm',
                formId: null,
                requiresPassword: false,
                password: '',
                passwordError: '',
                showPassword: false,
                async show(title, message, actionOrFormId, method = 'POST', buttonText = 'Confirm', requiresPassword = false) {
                    this.title = title;
                    this.message = message;
                    this.buttonText = buttonText;
                    this.requiresPassword = requiresPassword;
                    this.password = '';
                    this.passwordError = '';
                    this.showPassword = false;
                    if (typeof actionOrFormId === 'string' && actionOrFormId.startsWith('#')) {
                        this.formId = actionOrFormId;
                        this.action = '';
                        this.method = 'POST';
                    } else {
                        this.formId = null;
                        this.action = actionOrFormId;
                        this.method = method;
                    }
                    this.open = true;
                },
                async confirm() {
                    if (this.requiresPassword) {
                        const response = await fetch('/verify-password', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                password: this.password
                            })
                        });
                        const data = await response.json();
                        if (!data.success) {
                            this.passwordError = data.message || 'Invalid password';
                            return;
                        }
                    }
                    if (this.formId) {
                        document.querySelector(this.formId).submit();
                    } else {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = this.action;
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                        form.appendChild(csrf);
                        if (this.method !== 'POST') {
                            const methodField = document.createElement('input');
                            methodField.type = 'hidden';
                            methodField.name = '_method';
                            methodField.value = this.method;
                            form.appendChild(methodField);
                        }
                        document.body.appendChild(form);
                        form.submit();
                    }
                    this.open = false;
                }
            });
        });

        function confirmAction(title, message, actionOrFormId, method = 'POST', buttonText = 'Confirm', requiresPassword = false) {
            Alpine.store('modal').show(title, message, actionOrFormId, method, buttonText, requiresPassword);
        }
    </script>

    <!-- Confirmation Modal - Vertically Centered -->
    <div x-show="$store.modal.open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="$store.modal.open = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="$store.modal.title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" x-text="$store.modal.message"></p>
                            </div>
                            <div x-show="$store.modal.requiresPassword" class="mt-4">
                                <label for="modal-password" class="block text-sm font-medium text-gray-700">Enter your password to confirm</label>
                                <div class="relative">
                                    <input type="password" id="modal-password" x-model="$store.modal.password"
                                        :type="$store.modal.showPassword ? 'text' : 'password'"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10">
                                    <button type="button" @click="$store.modal.showPassword = !$store.modal.showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg x-show="!$store.modal.showPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="$store.modal.showPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-red-600 mt-1" x-text="$store.modal.passwordError"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="$store.modal.confirm()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" x-text="$store.modal.buttonText"></button>
                    <button type="button" @click="$store.modal.open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div x-data x-cloak class="fixed bottom-5 right-5 z-50 space-y-2">
        <template x-for="(toast, index) in $store.toast.toasts" :key="toast.id">
            <div x-show="$store.toast.visible[toast.id]"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-8"
                :class="{
                 'bg-green-600 text-white': toast.type === 'success',
                 'bg-red-600 text-white': toast.type === 'error'
             }"
                class="w-80 rounded-lg shadow-lg p-4 flex items-start justify-between">
                <div class="flex items-center">
                    <svg x-show="toast.type === 'success'" class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg x-show="toast.type === 'error'" class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span x-text="toast.message" class="text-sm font-medium"></span>
                </div>
                <button @click="$store.toast.dismiss(toast.id)" class="ml-4 text-white opacity-80 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('toast', {
                toasts: [],
                visible: {},
                nextId: 0,
                show(message, type = 'success') {
                    console.log('Toast show called:', message, type); // Debug
                    const id = this.nextId++;
                    this.toasts.push({
                        id,
                        message,
                        type
                    });
                    this.visible[id] = true;
                    setTimeout(() => {
                        if (this.visible[id]) {
                            this.visible[id] = false;
                            setTimeout(() => {
                                this.toasts = this.toasts.filter(t => t.id !== id);
                                delete this.visible[id];
                            }, 200);
                        }
                    }, 5000);
                },
                dismiss(id) {
                    if (this.visible[id]) {
                        this.visible[id] = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                            delete this.visible[id];
                        }, 200);
                    }
                }
            });
        });

        // Helper to show toast safely
        function showToast(message, type) {
            if (typeof Alpine !== 'undefined' && Alpine.store('toast')) {
                Alpine.store('toast').show(message, type);
            } else {
                console.log('Waiting for Alpine store...');
                setTimeout(() => showToast(message, type), 50);
            }
        }

        // Display Laravel flash messages
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
            showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
            showToast(@json(session('error')), 'error');
            @endif
        });
    </script>

</body>

</html>