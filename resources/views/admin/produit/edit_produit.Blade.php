{{-- <x-app-layout> --}}

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
:root{
    --primary:#3b71ca;
    --primary-soft:#eef4ff;
    --bg:#DFF5E3;
    --header-bg:#556B2F;
    --text-dark:#1f2937;
    --text-muted:#6b7280;
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
    max-width:900px;
    margin:auto;
}

/* HEADER */
.zendenta-header{
    margin-bottom:2rem;
    background-color:var(--header-bg); 
    padding:25px 30px;
    border-radius: var(--radius);
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
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
}

.form-control, textarea.form-control{
    border-radius:8px;
    padding:.5rem 1rem;
    width: 100%;
    box-sizing: border-box;
}

.row > .col-md-6 {
    margin-bottom: 1rem;
}

/* BUTTON */
.btn-primary{
    background-color:var(--primary);
    color:white;
    border:none;
    border-radius:50px;
    padding:.6rem 1.5rem;
    margin-top:1rem;
    width:100%;
    text-align:center;
    transition:.25s;
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

/* IMAGE PREVIEW */
.product-image{
    max-width:150px;
    margin-bottom:1rem;
    border-radius:8px;
    border:1px solid #ddd;
}
</style>

<div class="zendenta-container">

    {{-- HEADER --}}
    <div class="zendenta-header mb-4">
        <div>
            <h2 class="zendenta-title"><i class="bi bi-pencil-square me-2"></i>Modifier le Produit</h2>
            <p class="zendenta-subtitle mb-0">Mettez à jour les informations du produit.</p>
        </div>
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
        <form action="{{ route('produit_update', $produit->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- NOM + DESCRIPTION --}}
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nom du produit</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $produit->name) }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $produit->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- PRIX + STOCK --}}
            <div class="row">
                <div class="col-md-6">
                    <label for="prix" class="form-label">Prix (FCFA)</label>
                    <input type="number" name="prix" id="prix" class="form-control" value="{{ old('prix', $produit->prix) }}" required>
                    @error('prix')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $produit->stock) }}" required>
                    @error('stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- CATEGORIE + IMAGE --}}
            <div class="row">
                <div class="col-md-6">
                    <label for="categorie_id" class="form-label">Catégorie</label>
                    <select name="categorie_id" id="categorie_id" class="form-control" required>
                        <option value="">-- Sélectionnez une catégorie --</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('categorie_id', $produit->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Image du produit</label>
                    @if($produit->image)
                        <div>
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="Image du produit" class="product-image">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Mettre à jour</button>
        </form>
    </div>

</div>

{{-- </x-app-layout> --}}