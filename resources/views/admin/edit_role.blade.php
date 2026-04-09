{{-- <x-app-layout> --}}

<style>
:root{
    --primary:#3b71ca;           /* Couleur principale (bleu) */
    --bg: rgb(240, 255, 245);    /* Fond vert très clair */
    --card-bg: #fff;             /* Cartes blanches */
    --text-dark: #1f2937;        /* Texte principal */
    --text-muted: #6b7280;       /* Texte secondaire */
    --radius:12px;               /* Arrondis */
}

/* BODY / PAGE */
.role-page {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--bg);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* WRAPPER CARD */
.role-wrapper {
    width: 100%;
    max-width: 500px;
    background: var(--card-bg);
    padding: 30px;
    border-radius: var(--radius);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    text-align: center;
}

/* TITLE */
.role-wrapper h2 {
    color: var(--text-dark);
    font-weight: 700;
    margin-bottom: 20px;
    font-size: 1.5rem;
}

/* SUCCESS MESSAGE */
.success-message {
    margin-bottom: 20px;
    padding: 12px 20px;
    background-color: #d4edda;
    border-left: 6px solid #28a745;
    color: #155724;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 3px 10px rgba(40,167,69,0.2);
}

/* FORM */
.role-form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

/* CHECKBOX */
.role-checkbox {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    font-size: 16px;
    cursor: pointer;
    user-select: none;
    width: 100%;
}

.role-checkbox input[type="checkbox"] {
    margin-right: 12px;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

/* BUTTON */
.role-btn {
    background: var(--primary);
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 16px;
    font-weight: 600;
    border-radius: var(--radius);
    cursor: pointer;
    width: 100%;
    transition: 0.3s;
    margin-top: 20px;
}

.role-btn:hover {
    background: #2659a5; /* Bleu plus foncé au survol */
}

/* RESPONSIVE */
@media (max-width: 576px){
    .role-wrapper {
        padding: 20px;
    }

    .role-wrapper h2 {
        font-size: 1.3rem;
    }

    .role-btn {
        font-size: 14px;
        padding: 10px 20px;
    }
}
</style>

<div class="role-page">

    <div class="role-wrapper">

        <h2>Ajouter des rôles à : {{ $user->name }}</h2>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form class="role-form" action="{{ route('roles.update', $user->id) }}" method="POST">
            @csrf

            <strong>Rôles disponibles :</strong>

            @foreach($roles as $role)
                <label class="role-checkbox">
                    <input 
                        type="checkbox"
                        name="roles[]"
                        value="{{ $role->id }}"
                        {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                    >
                    {{ ucfirst($role->name) }}
                </label>
            @endforeach

            <button type="submit" class="role-btn">
                Ajouter les rôles
            </button>

        </form>

    </div>

</div>

{{-- </x-app-layout> --}}