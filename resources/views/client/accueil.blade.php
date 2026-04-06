{{-- resources/views/client/bord_client.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Compte Client TUASAL</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>

:root{
--primary:#3b71ca;
--primary-soft:#eef4ff;
--bg:#DFF5E3;
--header-bg:#556B2F;
--text-dark:#1f2937;
}

*{margin:0;padding:0;box-sizing:border-box;}

body{
font-family:'Roboto',sans-serif;
background:var(--bg);
color:var(--text-dark);
}

/* HEADER */

header{
background:var(--header-bg);
padding:14px 20px;
display:flex;
justify-content:space-between;
align-items:center;
color:#fff;
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

.logo span{
color:#ffd700;
}

.nav-icons{
display:flex;
gap:25px;
font-size:20px;
cursor:pointer;
align-items:center;
}

.nav-icons i:hover{
color:#ffd700;
}

/* CATEGORIES STYLE */
.categorie-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    margin: 10px 0;
}

.categorie-link {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 6px 10px;
    border-radius: 6px;
    background: var(--primary);
    font-size: 13px;
    transition: 0.2s;
}

.categorie-link:hover {
    color: #ffd700;
    background: var(--primary-soft);
}

/* BADGE PANIER */

.cart-icon{
position:relative;
color:white;
text-decoration:none;
}

.badge{
position:absolute;
top:-8px;
right:-10px;
background:red;
color:#fff;
font-size:11px;
padding:3px 6px;
border-radius:50%;
}

/* SEARCH */

.search-container{
display: flex;
align-items: center;
gap: 15px;
justify-content: center;
padding: 10px;
flex-wrap: wrap;
}

.search-box{
display:flex;
align-items:center;
background:#fff;
padding:8px 12px;
border-radius:6px;
flex: 1 1 250px; /* réduit la taille mais garde responsive */
max-width: 300px;
}

.search-box input{
border:none;
outline:none;
width:100%;
font-size:14px;
margin-left:10px;
}

/* PRODUITS */

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
transition:0.3s;
display:flex;
flex-direction:column;
}

.product-card:hover{
transform:translateY(-6px);
}

.product-img{
width:100%;
height:240px;
object-fit:contain; /* <-- garder toute l'image visible */
background:#f5f5f5; /* fond clair pour images plus petites */
}

.product-info{
padding:15px;
flex:1;
display:flex;
flex-direction:column;
justify-content:space-between;
}

.product-title{
font-weight:600;
font-size:15px;
margin-bottom:8px;
display:block;
}

.product-price{
font-weight:700;
color:#fff;
background:var(--primary);
padding:5px 10px;
border-radius:20px;
font-size:12px;
display:inline-block;
margin-bottom:10px;
}

.product-buttons{
display:flex;
gap:10px;
margin-top:8px;
}

.btn{
border:none;
padding:6px 10px;
border-radius:6px;
cursor:pointer;
font-size:12px;
text-decoration:none;
display:inline-flex;
align-items:center;
gap:4px;
}

.btn-view{
background:#3b71ca;
color:#fff;
}

.btn-cart{
background:#28a745;
color:#fff;
}

.product-description{
display:none;
margin-top:10px;
font-size:13px;
color:#444;
}
.user-login {
    color: #fff;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
}

.user-login:hover {
    color: #ffd700;
}
.btn-panier {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 7px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}

.btn-panier:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.btn-panier:active {
    transform: scale(0.95);
}

</style>
</head>

<body>

<header>

<div class="logo-section">
<i class="fas fa-bars"></i>
<div class="logo">TUASAL<span>★</span></div>
</div>

<div class="nav-icons">

<a href="{{ route('login') }}" class="user-login">
    <i class="fas fa-user-circle"></i> Connectez-vous
</a>

<a href="{{ route('panier') }}" class="cart-icon">
<i class="fas fa-shopping-cart"></i>

@if(session('panier'))
<span class="badge">{{ count(session('panier')) }}</span>
@endif
</a>
<i class="fas fa-bell"></i>

</div>

</header>

<!-- SEARCH + CATEGORIES SUR MÊME LIGNE -->
<div class="search-container">

<div class="search-box">
<i class="fas fa-search"></i>
<input type="text" id="searchInput" placeholder="Chercher un produit sur TUASAL">
</div>

<div class="categorie-container">
@foreach($categories as $categorie)
<a href="{{ route('produits.categorie', $categorie->id) }}" class="categorie-link">
<i class="fas fa-tag"></i> {{ $categorie->name }}
</a>
@endforeach
</div>

</div>

<div class="products-grid" id="productsGrid">

@foreach($produits as $produit)

<div class="product-card">

<img src="{{ asset('storage/'.$produit->image) }}" class="product-img">

<div class="product-info">

<span class="product-title">{{ $produit->name }}</span>

<div class="product-price">
{{ number_format($produit->prix,0,'',' ') }} FCFA
</div>

<div class="product-buttons">

<button class="btn btn-view" onclick="toggleDescription(this)">
<i class="fas fa-eye"></i> Voir
</button>

<form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn-panier">
        🛒 Ajouter
    </button>
</form>
</div>

<div class="product-description">
{{ $produit->description }}
</div>

</div>

</div>

@endforeach

</div>

<script>
function toggleDescription(button){
    const description = button.parentElement.nextElementSibling;
    if(description.style.display === "block"){
        description.style.display="none";
    }else{
        description.style.display="block";
    }
}
</script>

</body>
</html>