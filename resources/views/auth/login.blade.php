<x-guest-layout>
    <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg text-white">
        <h2 class="text-2xl font-bold mb-6 text-center text-[#10b981]">Connexion</h2>
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-[#f2f2f2]" />
                <x-text-input id="email" class="block mt-1 w-full bg-[#334155] border-[#334155] text-[#f2f2f2] focus:border-[#10b981] focus:ring-[#10b981]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-[#f2f2f2]" />

                <x-text-input id="password" class="block mt-1 w-full bg-[#334155] border-[#334155] text-[#f2f2f2] focus:border-[#10b981] focus:ring-[#10b981]"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded bg-[#334155] border-[#334155] text-[#10b981] focus:ring-[#10b981]" name="remember">
                    <span class="ms-2 text-sm text-[#f2f2f2]">{{ __('Se souvenir de moi') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-[#f2f2f2] hover:text-[#10b981] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#10b981]" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif

                <a href="{{ route('register') }}" class="text-sm text-[#f2f2f2] hover:text-[#10b981]">
                    {{ __('Créer un compte') }}
                </a>

                <x-primary-button class="bg-[#10b981] hover:bg-[#10b981]/90 focus:bg-[#10b981]/90 active:bg-[#10b981]/90 focus:ring-[#10b981]">
                    {{ __('Connexion') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
