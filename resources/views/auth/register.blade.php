<x-guest-layout>
    {{-- Container utama yang menyatu dengan x-guest-layout --}}
    <div class="w-full">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center text-3xl font-black text-black tracking-tighter">
                Shoewash    
            </a>
            <h1 class="text-xl font-bold leading-tight tracking-tight text-black md:text-2xl dark:text-black mt-6">
                Create your account
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Daftar sekarang untuk mulai merawat sepatu Anda.</p>
        </div>

        <form class="space-y-4 md:space-y-5" method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-input-label for="name" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-black" :value="__('Full Name')" />
                <x-text-input id="name" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    placeholder="Your Full Name"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-black" :value="__('Email Address')" />
                <x-text-input id="email" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="name@example.com"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="password" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-black" :value="__('Password')" />
                <x-text-input id="password" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-black" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-600 focus:border-blue-600 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    type="password"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <div class="pt-2">
                <x-button type="submit" variant="primary" class="w-full justify-center py-3.5 text-base font-bold shadow-lg shadow-blue-200 dark:shadow-none transition-all active:scale-95">
                    {{ __('Register to Shoewash') }}
                </x-button>
            </div>

            <p class="text-sm font-medium text-center text-gray-500 dark:text-gray-400 mt-6">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline transition-colors dark:text-blue-500">
                    Sign In
                </a>
            </p>
        </form>
    </div>
</x-guest-layout>