<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leo Revita Hair Salon</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Smooth navbar transition */
        .navbar-transition {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Solid background when scrolled (home page) */
        .navbar-scrolled {
            background-color: #6e0104 !important;
            /* matches bg-secondary */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{ mobileMenuOpen: false }">
    @php
    $isHome = request()->routeIs('home');
    @endphp

    <nav class="z-50 {{ $isHome ? 'fixed top-0 left-0 right-0' : 'sticky top-0' }} {{ $isHome ? 'navbar-transition bg-transparent' : 'bg-secondary shadow-sm' }}"
        @if($isHome)
        x-data="{ scrolled: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10; })"
        :class="{ 'navbar-scrolled shadow-md': scrolled, 'bg-transparent': !scrolled }"
        @endif>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 md:flex md:justify-between h-16">
                <!-- Empty left column (mobile only) to balance the hamburger -->
                <div class="md:hidden"></div>

                <!-- Logo – centered on mobile, left‑aligned on desktop -->
                <div class="flex items-center justify-center md:justify-start col-span-1 md:flex-initial">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('storage/assets/Logo - White.png') }}" alt="Logo" class="w-full h-12 object-cover">
                    </a>
                </div>

                <!-- Desktop Navigation (hidden on mobile) -->
                <div class="hidden md:flex items-stretch space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center px-6 text-white font-bold hover:text-primary transition border-b-4 border-transparent 
            {{ request()->routeIs('home') ? 'border-white' : 'border-transparent' }}">
                        Home
                    </a>
                    <a href="{{ route('services.index') }}" class="flex items-center px-6 text-white font-bold hover:text-primary transition border-b-4 border-transparent 
            {{ request()->routeIs('services.*') ? 'border-white' : 'border-transparent' }}">
                        Services
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center px-6 text-white font-bold hover:text-primary transition border-b-4 border-transparent 
            {{ request()->routeIs('about') ? 'border-white' : 'border-transparent' }}">
                        About
                    </a>
                </div>

                <!-- Desktop Auth (hidden on mobile) -->
                <div class="hidden md:flex items-center space-x-8">
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-primary">
                            <span>Hello, {{ explode(' ', Auth::user()->name)[0] ?: Auth::user()->name }}!</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('customer.dashboard') }}" class="block px-4 py-4 text-sm text-gray-700 hover:bg-primary-dark">My Profile</a>
                            <a href="{{ route('customer.appointments.index') }}" class="block px-4 py-4 text-sm text-gray-700 hover:bg-primary-dark">My Appointments</a>
                            <button @click="confirmAction('Logout', 'Are you sure you want to log out?', '{{ route('logout') }}', 'POST', 'Logout')"
                                class="block w-full text-left px-4 py-4 text-sm text-gray-700 hover:bg-primary-dark">Logout</button>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-white font-bold px-4 py-2 rounded-md hover:text-primary transition">Sign In</a>
                    @endauth
                </div>

                <!-- Mobile hamburger button (right column) -->
                <div class="md:hidden flex items-center justify-end col-span-1">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-secondary border-t border-primary-light">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-white hover:bg-primary-dark hover:text-primary rounded-md">Home</a>
                <a href="{{ route('services.index') }}" class="block px-3 py-2 text-white hover:bg-primary-dark hover:text-primary rounded-md">Services</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 text-white hover:bg-primary-dark hover:text-primary rounded-md">About</a>
                @auth
                <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-white hover:bg-primary-dark rounded-md">My Profile</a>
                <a href="{{ route('customer.appointments.index') }}" class="block px-3 py-2 text-white hover:bg-primary-dark rounded-md">My Appointments</a>
                <button @click="confirmAction('Logout', 'Are you sure you want to log out?', '{{ route('logout') }}', 'POST', 'Logout')" class="block w-full text-left px-3 py-2 text-white hover:bg-primary-dark rounded-md">Logout</button>
                @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-white hover:bg-primary-dark hover:text-primary rounded-md">Sign In</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!--@if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif-->
        @yield('content')
    </main>

    <!-- Footer (unchanged) -->
    <footer class="bg-secondary text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 space-x-6">
                <div class="flex flex-col items-center md:items-start">
                    <img src="{{ asset('storage/assets/Logo - White.png') }}" alt="Logo" class="h-14 w-auto mb-1">
                </div>
                <div class="flex flex-col items-center md:items-start py-6 text-center text-sm">
                    <p>&copy; {{ date('Y') }} Leo Revita Hair Salon. All rights reserved.</p>
                </div>
                <div class="flex flex-col items-center md:items-center">
                    <div class="flex space-x-4">
                        <a href="https://facebook.com" target="_blank" class="hover:text-primary-dark transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="hover:text-primary-dark transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z" />
                            </svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="hover:text-primary-dark transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.104c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.809-12.338c0-.213-.005-.425-.014-.636A9.936 9.936 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal scripts (unchanged) -->
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
                requiresReason: false,
                reason: '',
                async show(title, message, actionOrFormId, method = 'POST', buttonText = 'Confirm', requiresPassword = false, requiresReason = false) {
                    this.title = title;
                    this.message = message;
                    this.buttonText = buttonText;
                    this.requiresPassword = requiresPassword;
                    this.password = '';
                    this.passwordError = '';
                    this.showPassword = false;
                    this.requiresReason = requiresReason;
                    this.reason = '';
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
                    if (this.requiresReason && !this.reason.trim()) {
                        alert('Please provide a cancellation reason.');
                        return;
                    }
                    if (this.formId) {
                        // If we have a reason and the form doesn't have a field for it, append it
                        if (this.requiresReason) {
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'cancellation_reason';
                            input.value = this.reason;
                            document.querySelector(this.formId).appendChild(input);
                        }
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
                        if (this.requiresReason && this.reason && this.reason.trim() !== '') {
                            const reasonInput = document.createElement('input');
                            reasonInput.type = 'hidden';
                            reasonInput.name = 'cancellation_reason';
                            reasonInput.value = this.reason;
                            form.appendChild(reasonInput);
                        }
                        document.body.appendChild(form);
                        form.submit();
                    }
                    this.open = false;
                }
            });
        });

        function confirmAction(title, message, actionOrFormId, method = 'POST', buttonText = 'Confirm', requiresPassword = false, requiresReason = false) {
            Alpine.store('modal').show(title, message, actionOrFormId, method, buttonText, requiresPassword, requiresReason);
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
                            <!-- Cancel Reason-->
                            <div x-show="$store.modal.requiresReason" class="mt-4">
                                <label for="modal-reason" class="block text-sm font-medium text-gray-700">Cancellation Reason</label>
                                <textarea id="modal-reason" x-model="$store.modal.reason" rows="3" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" placeholder="Please explain why this appointment is being cancelled..."></textarea>
                                <p class="text-xs text-gray-500 mt-1" x-text="(255 - ($store.modal.reason?.length || 0)) + ' characters remaining'"></p>
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