{{-- <x-app-layout> --}}
    <x-slot name="header">
        <h2 class="page-title">Modifier la catégorie</h2>
    </x-slot>

    <style>
    :root{
        --primary-green:#3e7d48;
        --bg-light:#f4f7f6;
        --text-dark:#333;
        --text-gray:#777;
        --white:#fff;
    }

    body {
        font-family: Arial, sans-serif;
        background: #e2ede4;
    }

    .page-title {
        font-size: 1.8rem;
        margin-bottom: 25px;
        color: var(--text-dark);
    }

    .form-container {
        background: var(--white);
        padding: 30px;
        border-radius: 15px;
        max-width: 600px;
        margin: 40px auto;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .form-group {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-control {
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
        transition: 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-green);
        box-shadow: 0 0 5px rgba(62,125,72,0.3);
    }

    .btn-submit {
        background: var(--primary-green);
        color: var(--white);
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-submit:hover {
        background: #35663a;
    }

    .alert {
        background: #f8d7da;
        color: #842029;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #f5c2c7;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }
    </style>

    <div class="form-container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.update', $categorie->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" class="form-control" value="{{ $categorie->name }}" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $categorie->description }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Mettre à jour</button>
        </form>
    </div>
{{-- </x-app-layout> --}}