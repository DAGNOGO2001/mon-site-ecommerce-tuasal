<x-app-layout>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des commandes</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
body{
    font-family:'Roboto',sans-serif;
    background:#f5f6fa;
    padding:20px;
    color:#1f2937;
}
h2{ color:#556B2F; margin-bottom:20px; }
.table-container{ background:#fff; padding:15px; border-radius:8px; overflow-x:auto; }
table{ width:100%; border-collapse:collapse; }
th,td{ padding:12px; text-align:left; border-bottom:1px solid #eee; vertical-align:top; }
th{ background:#3b71ca; color:#fff; }
img{ width:50px; height:50px; object-fit:cover; border-radius:6px; margin-right:5px; }
.produit-wrapper{ display:flex; align-items:center; gap:8px; margin-bottom:8px; }
.btn-supprimer{ background:#f68b1e; color:#fff; padding:6px 12px; border:none; border-radius:5px; cursor:pointer; }
.btn-update{ background:#3b71ca; color:white; padding:6px 12px; border:none; border-radius:5px; cursor:pointer; margin-top:8px; }
select{ padding:5px; border-radius:5px; border:1px solid #ccc; margin-top:8px; }
.search-container{ margin-bottom:15px; }
#searchInput{ width:100%; padding:10px 15px; border-radius:6px; border:1px solid #ccc; font-size:14px; }

.status-enattente{ background:#fff3cd; color:#856404; padding:4px 10px; border-radius:15px; font-size:13px; display:inline-block; }
.status-confirmee{ background:#d4edda; color:#155724; padding:4px 10px; border-radius:15px; font-size:13px; display:inline-block; }
.status-livree{ background:#cce5ff; color:#004085; padding:4px 10px; border-radius:15px; font-size:13px; display:inline-block; }

.alert-success{ background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px; }
.alert-error{ background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px; }

#ajax-message{ display:none; padding:12px; border-radius:6px; margin-bottom:15px; font-weight:bold; }

@media(max-width:768px){
    table, thead, tbody, th, td, tr { display:block; }
    th { display:none; }
    td { position:relative; padding-left:50%; margin-bottom:10px; }
    td::before { position:absolute; top:12px; left:12px; width:45%; white-space:nowrap; font-weight:bold; content: attr(data-label); }
}

.badge {
    background:red;
    color:#fff;
    font-size:12px;
    padding:2px 6px;
    border-radius:50%;
    margin-left:5px;
}
</style>
</head>
<body>

<div class="container">
<h2>
Toutes les commandes
@if($messagesNonLus > 0)
    <span class="badge" id="messagesBadge">{{ $messagesNonLus }}</span>
@endif
</h2>

<div id="ajax-message"></div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-error">
        <i class="fas fa-times-circle"></i> {{ session('error') }}
    </div>
@endif

@if($commandes->isEmpty())
    <p>Aucune commande pour le moment.</p>
@else
<div class="search-container">
    <input type="text" id="searchInput" placeholder="Rechercher par client ou produit...">
</div>

<div class="table-container">
<table id="commandesTable">
<thead>
<tr>
    <th>Client</th>
    <th>Produits</th>
    <th>Quantités</th>
    <th>Date</th>
    <th>Statut</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($commandes as $commande)
<tr>
    <td data-label="Client">
        @if($commande->user)
            <strong>{{ $commande->user->name }}</strong><br>
            {{ $commande->user->email }}<br>
            {{ $commande->user->telephone ?? 'Téléphone non disponible' }}
        @else
            {{ $commande->name ?? 'Client sans nom' }}<br>
            {{ $commande->telephone ?? 'Téléphone non disponible' }}
        @endif
    </td>

    <td data-label="Produits">
        @foreach($commande->details as $detail)
        <div class="produit-wrapper">
            @if($detail->produit)
                <img src="{{ asset('storage/' . $detail->produit->image) }}" alt="{{ $detail->produit->name }}">
                <span>{{ $detail->produit->name }}</span>
            @else
                <span>Produit indisponible</span>
            @endif
        </div>
        @endforeach
    </td>

    <td data-label="Quantités">
        @foreach($commande->details as $detail)
            <div>{{ $detail->quantite }}</div>
        @endforeach
    </td>

    <td data-label="Date">{{ $commande->created_at->format('d/m/Y H:i') }}</td>

    <td data-label="Statut">
        <span id="badge-{{ $commande->id }}"
            class="@if($commande->statut == 'en attente') status-enattente
                   @elseif($commande->statut == 'confirmée') status-confirmee
                   @elseif($commande->statut == 'livrée') status-livree
                   @endif
            ">
            {{ $commande->statut }}
        </span>
        <br>
        <select id="select-{{ $commande->id }}">
            <option value="en attente" {{ $commande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
            <option value="confirmée" {{ $commande->statut == 'confirmée' ? 'selected' : '' }}>Confirmée</option>
            <option value="livrée" {{ $commande->statut == 'livrée' ? 'selected' : '' }}>Livrée</option>
        </select>
        <br>
        <button class="btn-update" onclick="mettreAJour({{ $commande->id }})">Mettre à jour</button>
    </td>

    <td data-label="Action">
        <form action="{{ route('commandes.supprimer', $commande->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-supprimer"><i class="fas fa-trash"></i> Supprimer</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endif
</div>

<script>
const searchInput = document.getElementById('searchInput');
const tableRows = document.querySelectorAll('#commandesTable tbody tr');

if(searchInput){
    searchInput.addEventListener('keyup', function(){
        const query = this.value.toLowerCase();
        tableRows.forEach(row => {
            const client = row.cells[0].textContent.toLowerCase();
            const produits = row.cells[1].textContent.toLowerCase();
            row.style.display = (client.includes(query) || produits.includes(query)) ? '' : 'none';
        });
    });
}

function afficherMessage(message, type='success'){
    const box = document.getElementById('ajax-message');
    box.style.display='block';
    box.textContent=message;
    if(type==='success'){
        box.style.backgroundColor='#d4edda';
        box.style.color='#155724';
        box.style.border='1px solid #c3e6cb';
    }else{
        box.style.backgroundColor='#f8d7da';
        box.style.color='#721c24';
        box.style.border='1px solid #f5c6cb';
    }
    setTimeout(()=>{ box.style.display='none'; },3000);
}

function mettreAJour(id){
    const statut = document.getElementById(`select-${id}`).value;

    fetch(`/admin/commandes/${id}/changer-statut-ajax`, {
        method:'PUT',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json'
        },
        body: JSON.stringify({statut:statut})
    })
    .then(async response=>{
        const data = await response.json();
        if(!response.ok) throw new Error(data.message || 'Erreur lors de la mise à jour');
        return data;
    })
    .then(data=>{
        if(data.success){
            const badge=document.getElementById(`badge-${id}`);
            badge.classList.remove('status-enattente','status-confirmee','status-livree');
            if(statut==='en attente') badge.classList.add('status-enattente');
            else if(statut==='confirmée') badge.classList.add('status-confirmee');
            else if(statut==='livrée') badge.classList.add('status-livree');
            badge.innerText=statut;

            // ⚡ mettre à jour le badge global
            const messagesBadge = document.getElementById('messagesBadge');
            if(messagesBadge){
                messagesBadge.innerText = data.count;
            }

            afficherMessage('Statut mis à jour !','success');
        }else{
            afficherMessage('Impossible de mettre à jour','error');
        }
    })
    .catch(error=>{
        console.error('Erreur :',error);
        afficherMessage('Erreur : '+error.message,'error');
    });
}

// 🔔 mettre à jour le badge toutes les 10 secondes
setInterval(()=>{
    fetch('{{ route("admin.commandes.non-lues") }}')
    .then(res=>res.json())
    .then(data=>{
        const messagesBadge = document.getElementById('messagesBadge');
        if(data.count>0){
            if(messagesBadge){
                messagesBadge.innerText=data.count;
            }else{
                const h2 = document.querySelector('.container h2');
                const span = document.createElement('span');
                span.classList.add('badge');
                span.id='messagesBadge';
                span.innerText=data.count;
                h2.appendChild(span);
            }
        }else if(messagesBadge){
            messagesBadge.remove();
        }
    })
    .catch(err=>console.log(err));
},10000);
</script>

</body>
</html>
</x-app-layout>