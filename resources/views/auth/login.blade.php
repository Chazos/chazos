<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">

            @php
             $logo = cg_get_project_logo();
            @endphp
}
            <a href="/">
                @if ($logo == "")
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                @else
                    <img class="w-20 h-20" src="{{ cg_get_project_logo() }}" alt="" srcset="">
                @endif
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif


                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>


        </form>
    </x-auth-card>

    @if(cg_get_setting('site_hide_create_account') == "no" || cg_get_setting('site_hide_create_account') == "")
    <div class="flex items-center justify-center relative bottom-20">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
            {{ __('Create account') }}
        </a>
    </div>
    @endif
</x-guest-layout>
