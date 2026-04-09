{{-- resources/views/admin/bord.blade.php --}}
<x-app-layout>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
.zendenta-container {
    padding: 20px;
    background-color: #f5f6fa;
    min-height: 100vh;
}

.zendenta-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #556B2F;
    padding: 15px 25px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.zendenta-title {
    font-size: 28px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.zendenta-subtitle {
    font-size: 14px;
    color: #e0e0e0;
}

.btn-modifier {
    background-color: #3b71ca;
    color: #fff;
    border: none;
    padding: 7px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
}

.btn-modifier:hover { background-color: #2a5dab; }

.btn-supprimer {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 7px 12px;
    border-radius: 6px;
}

.btn-supprimer:hover { background-color: #b02a37; }

.zendenta-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    width: 100%;
}

.zendenta-table-header {
    border-bottom: 1px solid #eee;
    margin-bottom: 15px;
}

.zendenta-table-header h5 {
    font-weight: 600;
    font-size: 18px;
}

.table {
    width: 100%;
    table-layout: fixed;
}

.table th, .table td {
    vertical-align: middle !important;
    text-align: center;
    font-size: 14px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.table th {
    background-color: #3b71ca;
    color: #fff;
}

.table td {
    background-color: #fdfdfd;
}

.produit-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
}

.produit-link {
    color: inherit;
    text-decoration: none;
}

.produit-link:hover {
    text-decoration: underline;
}

.stock-ok{
    color: green;
    font-weight: bold;
}

.stock-faible{
    color: orange;
    font-weight: bold;
}

.stock-rupture{
    color: red;
    font-weight: bold;
}

.search-container {
    margin-bottom: 15px;
}

#searchInput {
    width: 100%;
    padding: 10px 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}
</style>

<div class="zendenta-container">

    <div class="zendenta-header">
        <div>
            <h2 class="zendenta-title">
                <i class="bi bi-bag-fill"></i>
                Gestion des Produits
            </h2>
            <p class="zendenta-subtitle mb-0">
                Liste complète des produits disponibles.
            </p>
        </div>

        @if(auth()->user()->hasRole('admin'))
        <div>
            <a href="{{ route('form_produit') }}" class="btn btn-modifier">
                Ajouter Produit
            </a>
        </div>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success mb-4">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="zendenta-card">

        <div class="zendenta-table-header">
            <h5>Tous les produits</h5>
        </div>

        <!-- BARRE DE RECHERCHE -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Rechercher un produit...">
        </div>

        <div class="table-responsive">

            <table class="table table-bordered align-middle mb-0">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="productsGrid">

                    @foreach($produits as $produit)

                    <tr>
                        <td>{{ $produit->id }}</td>
                        <td>
                            @if($produit->image)
                            <a href="{{ route('produit_show', $produit->id) }}" class="produit-link">
                                <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->name }}" class="produit-img">
                            </a>
                            @else
                            <span class="text-muted">Pas d'image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('produit_show', $produit->id) }}" class="produit-link">
                                {{ $produit->name }}
                            </a>
                        </td>
                        <td>{{ $produit->description }}</td>
                        <td>{{ number_format($produit->prix,0,'',' ') }} FCFA</td>
                        <td>
                            @if($produit->stock == 0)
                            <span class="stock-rupture">
                                <i class="bi bi-x-circle-fill"></i> Rupture
                            </span>
                            @elseif($produit->stock <=50)
                            <span class="stock-faible">
                                <i class="bi bi-exclamation-triangle-fill"></i> {{ $produit->stock }} Stock faible
                            </span>
                            @else
                            <span class="stock-ok">
                                <i class="bi bi-check-circle-fill"></i> {{ $produit->stock }}
                            </span>
                            @endif
                        </td>
                        <td>{{ $produit->categorie->name ?? '-' }}</td>
                        <td>
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('edit_produit',$produit->id) }}" class="action-btn btn-modifier">
                                <i class="bi bi-pencil-square"></i> Modifier
                            </a>

                            <form action="{{ route('produit_delete',$produit->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-supprimer" onclick="return confirm('Supprimer ce produit ?')">
                                    <i class="bi bi-trash"></i> Supprimer
                                </button>
                            </form>
                            @else
                            <span class="text-muted">Voir détail</span>
                            @endif
                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- SCRIPT DE RECHERCHE -->
<script>
const searchInput = document.getElementById('searchInput');
const tableRows = document.querySelectorAll('#productsGrid tr');

searchInput.addEventListener('keyup', function() {
    const query = this.value.toLowerCase();

    tableRows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        if (rowText.indexOf(query) > -1) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

</x-app-layout>