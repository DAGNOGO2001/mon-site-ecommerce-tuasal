<x-guest-layout>
    <style>
        /* Corps */
        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f6fa;
            color: #1f2937;
        }

        /* Formulaire */
        form {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #3b71ca;
        }

        /* Labels */
        label {
            font-weight: 500;
            color: #1f2937;
        }

        /* Inputs */
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            margin-top: 5px;
            transition: border-color 0.2s;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #1bcf6f;
            outline: none;
        }

        /* Bouton */
        .btn-primary {
            background-color: #1bcf6f;
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
        }
        .btn-primary:hover {
            background-color: #16a44a;
        }

        /* Lien */
        a {
            color: #3b71ca;
            text-decoration: underline;
            transition: color 0.2s;
        }
        a:hover {
            color: #1bcf6f;
        }

        /* Checkbox */
        input[type="checkbox"] {
            accent-color: #1bcf6f;
        }

        .mt-4 { margin-top: 16px; }
        .ms-3 { margin-left: 12px; }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 16px; }
    </style>

    <!-- Statut de la session -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2>Connexion</h2>

        <!-- Adresse e-mail -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Se souvenir de moi -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <!-- Bouton de connexion + mot de passe oublié -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 btn-primary">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <!-- Lien vers la page d'inscription -->
        @if (Route::has('register'))
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}">
                    {{ __("Vous n'avez pas de compte ? Inscrivez-vous") }}
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>