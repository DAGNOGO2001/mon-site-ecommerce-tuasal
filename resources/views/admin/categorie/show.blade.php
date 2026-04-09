{{-- <x-app-layout> --}}

<!-- Lien vers le CSS du dashboard -->
<link rel="stylesheet" href="{{ asset('css/admin_bord.css') }}">

<div class="full-dashboard">
    <div class="dashboard">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="brand">🛒 E-Commerce Admin</div>

            <nav class="menu">
                <a href="{{ route('admin.bord') }}" class="active"><i class="bi bi-house-fill me-2"></i>Tableau de bord</a>
                {{-- <a href="{{ route('liste_produit') }}"><i class="bi bi-box-seam me-2"></i>Produits</a>
                <a href="{{ route('liste_client') }}"><i class="bi bi-people-fill me-2"></i>Clients</a>
                <a href="{{ route('liste_categorie') }}"><i class="bi bi-list-ul me-2"></i>Catégories</a>
                <a href="#">📊 Statistiques</a> --}}
            </nav>

            <div class="sidebar-footer">
                <div class="report-promo">
                    <p><b>Rapport ventes</b><br><small>Télécharger PDF</small></p>
                    <button class="btn-primary">Download</button>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="content">

            <header class="top-bar">
                <div class="search-box">🔍 Rechercher produit...</div>
                <div class="top-actions">
                    <button class="view-btn">Changer vue</button>
                    <span class="notif">🔔</span>
                </div>
            </header>

            <h1 class="title">Catégorie : {{ $categorie->name }}</h1>

            {{-- Lien vers la catégorie --}}
            <a href="{{ route('categories.show', $categorie->id) }}" class="category-link mb-4">
                <i class="bi bi-folder-fill me-2"></i>{{ $categorie->name }}
            </a>

            {{-- Liste des produits --}}
            <h2>Produits liés</h2>
            @if($categorie->produit->count() > 0)
                <ul class="product-list">
                    @foreach($categorie->produit as $produit)
                        <li class="mb-2">
                            <i class="bi bi-box-seam me-2"></i>
                            <a href="{{ route('produit.show', $produit->id) }}">{{ $produit->name }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucun produit pour cette catégorie.</p>
            @endif

        </main>

    </div>
</div>

<!-- CSS spécifique à cette page -->
<style>
.category-link, .product-list li a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: var(--text);
    font-size: 1.8rem;
}

.category-link:hover, .product-list li a:hover {
    color: var(--primary);
}

.product-list {
    list-style: none;
    padding-left: 0;
}

.product-list li {
    display: flex;
    align-items: center;
}
</style>

{{-- </x-app-layout> --}}