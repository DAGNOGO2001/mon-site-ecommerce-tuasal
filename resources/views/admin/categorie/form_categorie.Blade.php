{{-- <x-app-layout> --}}
    <div class="container mt-5 category-page">
        <h2 class="mb-4 text-center">Ajouter une catégorie</h2>

        <!-- Alertes erreurs -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('categories.store') }}" method="POST" class="category-form">
            @csrf
            <div class="mb-3 form-group">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3 form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success btn-rounded">Ajouter</button>
        </form>
    </div>

    <style>
        :root {
            --green-dark: #2f6b4a;
            --green-medium: #4a9d6a;
            --green-light: #e6f2ea;
            --text-dark: #1f3d2a;
        }

        body, .category-page {
            background-color: var(--green-light);
            color: var(--text-dark);
            font-family: 'Segoe UI', sans-serif;
        }

        h2 {
            color: var(--green-dark);
            font-weight: 600;
        }

        /* Formulaire centré et joli */
        .category-form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            font-size:1.5rem;
        }
        .category-form input{
            height:3rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--green-dark);
        }

        /* Tous les champs prennent 100% largeur */
        .form-control {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-sizing: border-box; /* important pour aligner textarea et input */
        }
        .form-control:focus {
            border-color: var(--green-dark);
            box-shadow: 0 0 5px rgba(47,107,74,0.3);
        }

        /* Bouton Ajouter */
        .btn-success {
            background-color: var(--green-dark);
            border-color: var(--green-dark);
            color: #fff;
            font-weight: 600;
        }
        .btn-success:hover {
            background-color: var(--green-medium);
            border-color: var(--green-medium);
        }

        .btn-rounded {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .btn-rounded:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
        }

        /* Alertes erreurs */
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c2c7;
            color: #842029;
        }

        /* Responsive */
        @media (max-width: 767px) {
            .category-form {
                padding: 20px;
            }
        }
    </style>
{{-- </x-app-layout> --}}