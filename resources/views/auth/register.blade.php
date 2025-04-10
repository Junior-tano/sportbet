<x-guest-layout>
    <div class="bg-[#1e293b] p-6 rounded-lg shadow-lg text-white">
        <h2 class="text-2xl font-bold mb-6 text-center text-[#10b981]">Inscription</h2>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nom')" class="text-[#f2f2f2]" />
                <x-text-input id="name" class="block mt-1 w-full bg-[#334155] border-[#334155] text-[#f2f2f2] focus:border-[#10b981] focus:ring-[#10b981]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-[#f2f2f2]" />
                <x-text-input id="email" class="block mt-1 w-full bg-[#334155] border-[#334155] text-[#f2f2f2] focus:border-[#10b981] focus:ring-[#10b981]" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-[#f2f2f2]" />

                <x-text-input id="password" class="block mt-1 w-full bg-[#334155] border-[#334155] text-[#f2f2f2] focus:border-[#10b981] focus:ring-[#10b981]"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-[#f2f2f2]" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-[#334155] border-[#334155] text-[#f2f2f2] focus:border-[#10b981] focus:ring-[#10b981]"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-[#f2f2f2] hover:text-[#10b981] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#10b981]" href="{{ route('login') }}">
                    {{ __('Déjà inscrit ?') }}
                </a>

                <x-primary-button class="bg-[#10b981] hover:bg-[#10b981]/90 focus:bg-[#10b981]/90 active:bg-[#10b981]/90 focus:ring-[#10b981]">
                    {{ __('S\'inscrire') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
