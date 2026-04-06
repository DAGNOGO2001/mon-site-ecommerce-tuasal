<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>{{ $produit->name }}</title>

<style>

body{
font-family:Arial;
background:#f5f6fa;
padding:40px;
}

.container{
max-width:900px;
margin:auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
}

img{
width:300px;
border-radius:10px;
}

.title{
font-size:26px;
font-weight:bold;
margin-bottom:10px;
}

.price{
font-size:20px;
color:#3b71ca;
margin-top:10px;
}

.description{
margin-top:20px;
color:#555;
}

.btn{
display:inline-block;
margin-top:20px;
padding:10px 15px;
background:#556B2F;
color:white;
text-decoration:none;
border-radius:5px;
}

</style>

</head>

<body>

<div class="container">

<h1 class="title">{{ $produit->name }}</h1>

<img src="{{ asset('storage/'.$produit->image) }}">

<div class="price">
{{ number_format($produit->prix,0,'',' ') }} FCFA
</div>

<div class="description">
{{ $produit->description }}
</div>

<a href="{{ route('client_accueil') }}" class="btn">
Retour aux produits
</a>

</div>

</body>
</html>