<x-guest-layout>
    {{-- Container utama yang menyatu dengan x-guest-layout --}}
    <div class="w-full">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center text-3xl font-black text-black tracking-tighter">
                Shoewash    
            </a>
            <h1 class="text-xl font-bold leading-tight tracking-tight text-black md:text-2xl dark:text-black mt-6">
                Sign in to your account
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form class="space-y-4 md:space-y-5" method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input-label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-white" :value="__('Email Address')" />
                <x-text-input id="email" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="name@example.com"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="password" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-white" :value="__('Password')" />
                <x-text-input id="password" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="flex items-center justify-between py-2">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember_me" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded-md bg-gray-50 text-blue-600 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember_me" class="text-gray-500 dark:text-gray-300 select-none">{{ __('Remember me') }}</label>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 hover:underline transition-colors dark:text-blue-500">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <x-button type="submit" variant="primary" class="w-full justify-center py-3.5 text-base font-bold shadow-lg shadow-blue-200 dark:shadow-none transition-all active:scale-95">
                    {{ __('Sign In to Shoewash') }}
                </x-button>
            </div>

            <p class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 mt-6">
                Don’t have an account yet? 
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline transition-colors dark:text-blue-500">
                    Create Account
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>