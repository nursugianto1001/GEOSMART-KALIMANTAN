<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-green-100 via-green-50 to-white flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-gradient-to-br from-green-600 to-green-700 rounded-2xl flex items-center justify-center shadow-lg shadow-green-200/50 mb-6">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-green-900 mb-2">Forgot Password?</h2>
                <p class="text-gray-600">No worries, we'll help you reset it</p>
            </div>

            <!-- Reset Password Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl shadow-green-100/30 border border-green-100/50 p-8">
                <!-- Information Message -->
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-green-100/50 border border-green-200/50 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-sm text-gray-700 leading-relaxed">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>
                    </div>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium text-sm" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <x-text-input 
                                id="email" 
                                class="block w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-50/50 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 text-gray-900 placeholder-gray-400" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus
                                placeholder="Enter your email address" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <x-primary-button class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:ring-4 focus:ring-green-500/30 text-white font-semibold py-3 px-4 rounded-xl shadow-lg shadow-green-600/25 hover:shadow-xl hover:shadow-green-700/30 transform hover:-translate-y-0.5 transition-all duration-200 border-0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-sm text-green-600 hover:text-green-700 font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded-md px-2 py-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Login
                    </a>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="text-center">
                <div class="flex items-center justify-center space-x-2 text-gray-500 text-sm">
                    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent flex-1"></div>
                    <span class="px-3 bg-gradient-to-br from-green-50 to-white rounded-full">Password Recovery</span>
                    <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent flex-1"></div>
                </div>
            </div>
        </div>

        <!-- Background Decorative Elements -->
        <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-green-200/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-green-100/30 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-br from-green-50/40 to-transparent rounded-full blur-3xl"></div>
        </div>
    </div>
</x-guest-layout>