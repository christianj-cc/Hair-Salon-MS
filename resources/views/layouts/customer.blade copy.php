<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hair Salon MS') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Top Navigation – red background -->
    <nav class="bg-primary shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span><img src="{{ asset('storage/assets/Logo - White.png') }}" alt="Logo" class="w-full h-12 object-cover"></span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-stretch space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center px-6 text-white hover:text-gray-200 transition border-b-4 border-transparent 
        {{ request()->routeIs('home') ? 'border-white' : 'border-transparent' }}">
                        Homeee
                    </a>
                    <a href="{{ route('services.index') }}" class="flex items-center px-6 text-white hover:text-gray-200 transition border-b-4 border-transparent 
        {{ request()->routeIs('services.*') ? 'border-white' : 'border-transparent' }}">
                        Services
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center px-6 text-white hover:text-gray-200 transition border-b-4 border-transparent 
        {{ request()->routeIs('about') ? 'border-white' : 'border-transparent' }}">
                        About
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-gray-200">
                            <span>Hello, {{ explode(' ', Auth::user()->name)[0] ?: Auth::user()->name }}!</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="{{ route('customer.dashboard') }}" class="block px-4 py-4 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                            <a href="{{ route('customer.appointments.index') }}" class="block px-4 py-4 text-sm text-gray-700 hover:bg-gray-100">My Appointments</a>
                            <button @click="confirmAction('Logout', 'Are you sure you want to log out?', '{{ route('logout') }}', 'POST', 'Logout')" class="block w-full text-left px-4 py-4 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-primary font-bold px-4 py-2 rounded-md hover:bg-primary-dark transition">Sign In</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
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
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 max-w-7xl mx-auto mt-4">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 max-w-7xl mx-auto mt-4">
            {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer (dark gray, consistent with admin/front desk) -->
    <footer class="bg-primary text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 space-x-6">
                <!-- Logo & Description -->
                <div class="flex flex-col items-center md:items-start">
                    <img src="{{ asset('storage/assets/Logo - White.png') }}" alt="Logo" class="h-14 w-auto mb-1">
                </div>

                <!-- Copyright -->
                <div class="flex flex-col items-center md:items-start py-6 text-center text-sm">
                    <p>&copy; {{ date('Y') }} Leo Revita Hair Salon. All rights reserved.</p>
                </div>

                <!-- Social Links -->
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

    <!-- Modal and script (same as before) -->
    <div x-show="$store.modal.open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="$store.modal.title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" x-text="$store.modal.message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form :action="$store.modal.formId ? '#' : $store.modal.action" method="POST" class="sm:ml-3" @submit.prevent="if ($store.modal.formId) { document.querySelector($store.modal.formId).submit(); $store.modal.open = false; } else { $el.submit(); }">
                        @csrf
                        <input type="hidden" name="_method" :value="$store.modal.method">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" x-text="$store.modal.buttonText"></button>
                    </form>
                    <button type="button" @click="$store.modal.open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
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
                async show(title, message, actionOrFormId, method = 'POST', buttonText = 'Confirm', requiresPassword = false) {
                    this.title = title;
                    this.message = message;
                    this.buttonText = buttonText;
                    this.requiresPassword = requiresPassword;
                    this.password = '';
                    this.passwordError = '';
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
                    // Proceed with form submission
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
</body>

</html>