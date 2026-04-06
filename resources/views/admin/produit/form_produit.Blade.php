{{-- <x-app-layout> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
:root{
    --primary:#3b71ca;
    --bg:#DFF5E3;
    --header-bg:#556B2F;
    --radius:14px;
}

/* BODY */
body{
    background:var(--bg);
    font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;
}

/* CONTAINER */
.zendenta-container{
    padding:2rem;
    max-width:100%;
    margin:auto;
}

/* HEADER */
.zendenta-header{
    margin-bottom:2rem;
    background-color:var(--header-bg); 
    padding:25px 30px;
    border-radius: var(--radius);
    color:white;
}

.zendenta-title{
    font-weight:700;
    color:white;
    margin-bottom:0.5rem;
}

.zendenta-subtitle{
    color:#dcdcdc; 
    font-size:.95rem;
}

/* FORM */
.form-card{
    background:#fff;
    border-radius:var(--radius);
    box-shadow:0 10px 30px rgba(0,0,0,.04);
    padding:2rem;
    width:100%;
    box-sizing:border-box;
}

.form-row {
    display: flex;
    gap:1rem;
    width:100%;
    flex-wrap: wrap;
}

.form-col {
    flex: 1 1 48%; /* 2 champs par ligne */
    min-width: 300px;
}

.form-control{
    width:100%;
    border-radius:8px;        /* même arrondi que textarea */
    padding:1rem 1.2rem;      /* même padding que textarea */
    font-size:1.05rem;        /* même taille de texte */
    min-height:100px;         /* même hauteur que textarea */
    box-sizing:border-box;
}

textarea.form-control {
    min-height:100px;         /* identique aux inputs */
}

.btn-primary{
    background-color:var(--primary);
    color:white;
    border:none;
    border-radius:50px;
    padding:.6rem 1.5rem;
    margin-top:1rem;
   display: inline-block; /* ou block si tu veux qu'il remplisse toute la ligne */
   width: 100%;           /* remplissage complet du conteneur */
   text-align: center; 

}

.btn-primary:hover{
    background-color:#2b50a3;
}

.text-danger{
    font-size:.85rem;
}

/* ALERT */
.alert-success{
    border:none;
    border-radius:var(--radius);
    background:#ecfdf5;
    color:#047857;
}
</style>

<div class="zendenta-container">

    {{-- HEADER --}}
    <div class="zendenta-header mb-4">
        <h2 class="zendenta-title"><i class="bi bi-plus-circle me-2"></i>Ajouter un Produit</h2>
        <p class="zendenta-subtitle mb-0">Remplissez le formulaire ci-dessous pour ajouter un nouveau produit.</p>
    </div>

    {{-- MESSAGE SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success mb-4 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- FORMULAIRE --}}
    <div class="form-card">
        <form action="{{ route('produit_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Ligne 1 : Nom et Description --}}
            <div class="form-row mb-3">
                <div class="form-col">
                    <label for="name" class="form-label">Nom du produit</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-col">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Ligne 2 : Prix et Stock --}}
            <div class="form-row mb-3">
                <div class="form-col">
                    <label for="prix" class="form-label">Prix (FCFA)</label>
                    <input type="number" name="prix" id="prix" class="form-control" value="{{ old('prix') }}" required>
                    @error('prix')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-col">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required>
                    @error('stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Ligne 3 : Catégorie et Image --}}
            <div class="form-row mb-3">
                <div class="form-col">
                    <label for="categorie_id" class="form-label">Catégorie</label>
                    <select name="categorie_id" id="categorie_id" class="form-control" required>
                        <option value="">-- Sélectionnez une catégorie --</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-col">
                    <label for="image" class="form-label">Image du produit</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Enregistrer</button>
        </form>
    </div>

</div>

{{-- </x-app-layout> --}}