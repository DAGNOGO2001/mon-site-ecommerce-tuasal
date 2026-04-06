{{-- <x-app-layout> --}}

<script src="//unpkg.com/alpinejs" defer></script>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
:root{
    --primary:#3b71ca;
    --bg:#DFF5E3;
    --header-bg:#556B2F;
    --btn-green:#28a745;
}

body{
    font-family:'Roboto',sans-serif;
    background:var(--bg);
    margin:0;
}

/* HEADER */
header{
    background:var(--header-bg);
    padding:12px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:#fff;
    position:sticky;
    top:0;
    z-index:100;
}

.logo-section{
    display:flex;
    align-items:center;
    gap:15px;
}

.logo{
    font-weight:900;
    font-size:22px;
}

.logo span{color:#ffd700;}

/* NAV ICONS */
.nav-icons{
    display:flex;
    align-items:center;
    gap:20px;
    font-size:20px;
}

.nav-icons a{
    color:#fff;
    text-decoration:none;
    position:relative;
}

.badge{
    position:absolute;
    top:-5px;
    right:-10px;
    background:red;
    color:#fff;
    font-size:12px;
    padding:2px 6px;
    border-radius:50%;
}

/* DROPDOWN */
.dropdown{
    position:relative;
}

.dropdown-menu{
    position:absolute;
    right:0;
    top:35px;
    background:#fff;
    color:#000;
    min-width:150px;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
    overflow:hidden;
    z-index:200;
}

.dropdown-menu a,
.dropdown-menu button{
    display:block;
    width:100%;
    padding:10px;
    border:none;
    background:none;
    text-align:left;
    cursor:pointer;
    text-decoration:none;
    color:#000;
}

.dropdown-menu a:hover,
.dropdown-menu button:hover{
    background:#f2f2f2;
}

/* SEARCH */
.search-container{padding:15px;}
.search-box{
    display:flex;
    align-items:center;
    background:#fff;
    padding:10px;
    border-radius:8px;
}

.search-box input{
    border:none;
    outline:none;
    width:100%;
    margin-left:10px;
}

/* MENU */
.menu-header{
    padding:15px;
    font-size:13px;
    font-weight:bold;
}

.menu-list{
    background:#fff;
    border-radius:10px;
    margin:0 15px 20px 15px;
}

.menu-item{
    display:flex;
    justify-content:space-between;
    padding:15px;
    text-decoration:none;
    color:inherit;
    border-bottom:1px solid #eee;
}

/* PRODUCTS */
.products-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:20px;
    padding:20px;
}

.product-card{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

.product-img{
    width:100%;
    height:200px;
    object-fit:contain;
}

.product-info{
    padding:15px;
    text-align:center;
}

.btn{
    padding:6px 10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.btn-cart{background:var(--btn-green);color:#fff;}

.btn-view{
    background:#3b71ca;
    color:#fff;
    margin:5px 0;
}

/* DESCRIPTION 🔥 */
.product-description{
    display:none;
    margin-top:12px;
    font-size:15px;
    line-height:1.6;
    color:#333;
    background:#f9f9f9;
    padding:10px;
    border-radius:8px;
}

/* RESPONSIVE */
@media (max-width:768px){

    .nav-icons{
        display:none;
    }

    header{
        width:100%;
        padding:12px 10px;
    }

    .products-grid{
        grid-template-columns:repeat(1,1fr);
    }
}
</style>

<!-- HEADER -->
<header x-data="{ mobileOpen: false }">

    <div class="logo-section">
        <i class="fas fa-bars" style="cursor:pointer; font-size:22px;"></i>
        <div class="logo">TUASAL<span>★</span></div>
    </div>

    <div class="nav-icons">

        <div x-data="{ open: false }" class="dropdown">

            <i class="fas fa-user-circle"
               @click="open = !open"
               style="cursor:pointer; font-size:22px;">
            </i>

            <div x-show="open"
                 @click.away="open = false"
                 class="dropdown-menu">

                <a href="{{ route('profile.edit') }}">Profil</a>

                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Déconnexion</button>
                </form>
                @else
                <a href="{{ route('login') }}">Connexion</a>
                @endauth

            </div>
        </div>

        <a href="{{ route('panier') }}">
            <i class="fas fa-shopping-cart"></i>
            @if(session('panier'))
                <span class="badge">{{ count(session('panier')) }}</span>
            @endif
        </a>

        <a href="{{ route('liste_commande') }}">
            <i class="fas fa-bell"></i>
            <span class="badge">{{ $messagesNonLus ?? 0 }}</span>
        </a>

    </div>

</header>

<!-- SEARCH -->
<div class="search-container">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Chercher un produit">
    </div>
</div>

<!-- MENU -->
<div class="menu-header">Votre compte TUASAL</div>
<div class="menu-list">
    <a href="{{ route('panier') }}" class="menu-item">Panier</a>
    <a href="{{ route('liste_commande') }}" class="menu-item">Vos commandes</a>
    <a href="{{ route('categorie_client') }}" class="menu-item">Produits</a>
    <a href="{{ url('/avis') }}" class="menu-item">⭐ Donner un avis</a>
</div>

<!-- PRODUCTS -->
<div class="menu-header">Produits disponibles</div>

<div class="products-grid">

@foreach($produits as $produit)
    <div class="product-card">

        <img src="{{ asset('storage/' . $produit->image) }}" class="product-img">

        <div class="product-info">

            <h4>{{ $produit->name }}</h4>

            <!-- BUTTON -->
            <button class="btn btn-view" onclick="toggleDescription(this)">
                <i class="fas fa-eye"></i> Voir
            </button>

            <p>{{ number_format($produit->prix,0,'',' ') }} FCFA</p>

            <!-- DESCRIPTION -->
            <div class="product-description">
                {{ $produit->description }}
            </div>

            <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
                @csrf
                <button class="btn btn-cart">Ajouter</button>
            </form>

        </div>
    </div>
@endforeach

</div>

<!-- SCRIPT -->
<script>
function toggleDescription(button){
    const description = button.parentElement.querySelector('.product-description');

    if(description.style.display === "block"){
        description.style.display = "none";
        button.innerHTML = '<i class="fas fa-eye"></i> Voir';
    } else {
        description.style.display = "block";
        button.innerHTML = '<i class="fas fa-eye-slash"></i> Masquer';
    }
}
</script>

{{-- </x-app-layout> --}}