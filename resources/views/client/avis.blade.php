<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Avis clients</title>

<style>
/* =======================
   BASE
======================= */
body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    margin:0;
    padding:0;
}

/* =======================
   HEADER
======================= */
.header{
    background:#ff6600;
    color:white;
    text-align:center;
    padding:20px;
}

.header h2{
    margin:0;
}

/* =======================
   FORMULAIRE
======================= */
.form-container{
    width:90%;
    max-width:500px;
    margin:20px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

label{
    font-weight:bold;
}

select, textarea{
    width:100%;
    padding:10px;
    margin-top:8px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:6px;
    outline:none;
}

button{
    width:100%;
    padding:12px;
    background:#ff6600;
    color:white;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#e65c00;
}

/* =======================
   MESSAGE SUCCESS
======================= */
.success{
    text-align:center;
    color:green;
    margin-top:10px;
}

/* =======================
   LISTE AVIS
======================= */
.container{
    width:90%;
    max-width:700px;
    margin:20px auto;
}

.card{
    background:white;
    padding:15px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
}

.user{
    font-weight:bold;
    color:#333;
}

.stars{
    color:#ffb400;
    font-size:18px;
    margin:5px 0;
}

.comment{
    color:#444;
    margin-top:5px;
}

.date{
    font-size:12px;
    color:gray;
    margin-top:10px;
}

/* =======================
   RESPONSIVE MOBILE
======================= */
@media screen and (max-width:768px){

    .form-container,
    .container{
        width:95%;
    }

    .header{
        padding:15px;
    }

    button{
        font-size:14px;
    }

    .card{
        padding:12px;
    }

    .stars{
        font-size:16px;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h2>⭐ Avis clients</h2>
</div>

<!-- MESSAGE SUCCESS -->
@if(session('success'))
    <p class="success">{{ session('success') }}</p>
@endif

<!-- FORMULAIRE -->
<div class="form-container">

<form method="POST" action="/avis">
    @csrf

    <label>Note ⭐</label>
    <select name="note" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>

    <label>Commentaire 💬</label>
    <textarea name="commentaire" rows="4" required></textarea>

    <button type="submit">Envoyer</button>
</form>

</div>

<!-- LISTE AVIS -->
<div class="container">

<h3 style="text-align:center;">📝 Derniers avis</h3>

@foreach($avis as $a)
    <div class="card">

        <div class="user">👤 {{ $a->utilisateur ?? 'Anonyme' }}</div>

        <div class="stars">
            @for ($i = 1; $i <= 5; $i++)
                {{ $i <= $a->note ? '⭐' : '☆' }}
            @endfor
        </div>

        <div class="comment">
            {{ $a->commentaire }}
        </div>

        <div class="date">
            📅 {{ $a->created_at->format('d/m/Y H:i') }}
        </div>

    </div>
@endforeach

</div>

</body>
</html>