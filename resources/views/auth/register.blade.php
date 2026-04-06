<x-guest-layout>

<style>
body{
    background:#DFF5E3;
    font-family: 'Roboto', sans-serif;
}

.form-container{
    background:white;
    padding:35px;
    border-radius:10px;
    width:400px;
    margin:auto;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.form-title{
    text-align:center;
    color:#556B2F;
    margin-bottom:20px;
    font-size:22px;
    font-weight:bold;
}

input{
    width:100%;
    padding:10px;
    border-radius:6px;
    border:1px solid #ddd;
    margin-top:6px;
}

input:focus{
    border-color:#556B2F;
    outline:none;
}

label{
    font-weight:500;
}

.btn-register{
    background:#556B2F;
    color:white;
    padding:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    width:100%;
    font-size:16px;
    margin-top:15px;
}

.btn-register:hover{
    background:#445622;
}

.login-link{
    text-align:center;
    margin-top:15px;
}

.login-link a{
    color:#f68b1e;
    text-decoration:none;
}

.login-link a:hover{
    text-decoration:underline;
}
</style>


<div class="form-container">

<h2 class="form-title">Créer un compte</h2>

<form method="POST" action="{{ route('register') }}">
@csrf

<!-- Nom -->
<div>
<x-input-label for="name" :value="__('Nom')" />
<x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus />
<x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Téléphone -->
<div class="mt-3">
<x-input-label for="telephone" :value="__('Téléphone')" />
<x-text-input id="telephone" type="text" name="telephone" :value="old('telephone')" required />
<x-input-error :messages="$errors->get('telephone')" class="mt-2" />
</div>

<!-- Email -->
<div class="mt-3">
<x-input-label for="email" :value="__('Email')" />
<x-text-input id="email" type="email" name="email" :value="old('email')" required />
<x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Mot de passe -->
<div class="mt-3">
<x-input-label for="password" :value="__('Mot de passe')" />
<x-text-input id="password" type="password" name="password" required />
<x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirmation mot de passe -->
<div class="mt-3">
<x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
<x-text-input id="password_confirmation" type="password" name="password_confirmation" required />
<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<button class="btn-register">
S'inscrire
</button>

<div class="login-link">
Déjà inscrit ?  
<a href="{{ route('login') }}">Se connecter</a>
</div>

</form>
</div>

</x-guest-layout>