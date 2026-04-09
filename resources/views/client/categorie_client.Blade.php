<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Produits disponibles</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body{
    font-family:Arial;
    background:#f5f5f5;
    margin:0;
}
.container{
    display:flex;
    min-height:100vh;
}
/* CATEGORIES */
.categories{
    width:250px;
    background:white;
    padding:20px;
    border-right:1px solid #1bcf6f;
}
.categories h3{
    margin-bottom:15px;
}
.categories a{
    display: block;
    padding: 10px;
    text-decoration: none;
    color:black;
    border-radius: 5px;
    margin-bottom: 5px;
    transition: 0.2s;
    font-size: 1.2rem;  
}
.categories a:hover{
    background: #1bcf6f;
    color:white;
}

/* SEARCH BAR */
#searchInput {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin-bottom: 15px;
}

/* PRODUITS */
.products{
    flex:1;
    padding:20px;
}
.products h2{
    margin-bottom:20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}
.products h2 .cart-badge{
    background:red;
    color:white;
    padding:2px 8px;
    border-radius:50%;
    font-size:14px;
}

/* Grid produits */
.products-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:20px;
}
.product-card{
    background:white;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
    overflow:hidden;
    transition:0.3s;
}
.product-card:hover{
    transform:translateY(-5px);
}
.product-card img{
    width:100%;
    height:220px;
    object-fit:cover;
}
.product-info{
    padding:12px;
}
.product-name{
    font-weight:bold;
    margin-bottom:5px;
}
.product-price{
    color:#3b71ca;
    font-weight:bold;
    margin-bottom:10px;
}
.btn-panier{
    background:#28a745;
    color:white;
    border:none;
    padding:7px 12px;
    border-radius:5px;
    cursor:pointer;
    font-size:13px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:5px;
}
.btn-panier:hover{
    background:#1e7e34;
}
.no-product{
    background:white;
    padding:20px;
    border-radius:8px;
    text-align:center;
}
</style>
</head>
<body>

<div class="container">

    <!-- CATEGORIES -->
    <div class="categories">
        <h3><i class="fas fa-list"></i> Catégories</h3>
        @foreach($categories as $categorie)
            <a href="{{ route('produits.categorie', $categorie->id) }}">
                <i class="fas fa-tag"></i> {{ $categorie->name }}
            </a>
        @endforeach
    </div>

    <!-- PRODUITS -->
    <div class="products">
        <h2>
            <span><i class="fas fa-box"></i> Produits disponibles</span>
            <a href="{{ route('panier') }}" class="btn-panier">
                <i class="fas fa-shopping-cart"></i> Panier 
                <span class="cart-badge">{{ count(session('panier', [])) }}</span>
            </a>
        </h2>

        <!-- SEARCH -->
        <input type="text" id="searchInput" placeholder="🔍 Rechercher un produit...">

        @if($produits->count() > 0)
        <div class="products-grid" id="productsGrid">
            @foreach($produits as $produit)
            <div class="product-card">
                <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->name }}">
                <div class="product-info">
                    <div class="product-name">{{ $produit->name }}</div>
                    <div class="product-price">{{ number_format($produit->prix,0,'',' ') }} FCFA</div>
                <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
                @csrf
               <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn-panier">
        <i class="fas fa-cart-plus"></i> Ajouter au panier
    </button>
</form>
            </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="no-product">
            <i class="fas fa-box-open" style="font-size:40px;color:#ccc"></i>
            <p>Aucun produit dans cette catégorie</p>
        </div>
        @endif

    </div>

</div>

<script>
const searchInput = document.getElementById('searchInput');
const productsGrid = document.getElementById('productsGrid');

searchInput.addEventListener('keyup', function() {
    const query = this.value.toLowerCase();
    const cards = productsGrid.getElementsByClassName('product-card');

    Array.from(cards).forEach(card => {
        const name = card.querySelector('.product-name').innerText.toLowerCase();
        const price = card.querySelector('.product-price').innerText.toLowerCase();
        if(name.includes(query) || price.includes(query)){
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

</body>
</html>