<x-app-layout>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes commandes</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
body{
    font-family:"Segoe UI", Arial, sans-serif;
    background:#f5f7fb;
    margin:0;
    padding:20px;
}
h2{
    text-align:center;
    color:#3b71ca;
    margin-bottom:25px;
}
h2 .badge {
    background:red;
    color:white;
    font-size:12px;
    padding:2px 6px;
    border-radius:50%;
    margin-left:5px;
}
.search-bar{
    display:flex;
    justify-content:center;
    margin-bottom:20px;
}
.search-bar input{
    width:320px;
    padding:9px 12px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:14px;
}
.search-bar button{
    padding:9px 14px;
    margin-left:5px;
    border:none;
    border-radius:6px;
    background:#3b71ca;
    color:white;
    cursor:pointer;
}
.search-bar button:hover{
    background:#2f5db3;
}
.table-container{
    overflow-x:auto;
}
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}
th, td{
    padding:12px;
    border-bottom:1px solid #eee;
    vertical-align:top;
}
th{
    background:#3b71ca;
    color:white;
    text-align:left;
}
tr:hover{
    background:#f9fafb;
}
.product-wrapper{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:6px;
}
.product-wrapper img{
    width:50px;
    height:50px;
    object-fit:cover;
    border-radius:6px;
}
.status{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:13px;
    font-weight:500;
}
.status-enattente{ background:#fff3cd; color:#856404; }
.status-confirmee{ background:#d4edda; color:#155724; }
.status-livree{ background:#cce5ff; color:#004085; }
.no-orders{
    text-align:center;
    padding:25px;
    background:white;
    border-radius:8px;
    color:#666;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}
.btn-delete{
    display:inline-block;
    padding:5px 10px;
    font-size:13px;
    background:#dc3545;
    color:white;
    border-radius:6px;
    text-decoration:none;
}
.btn-delete:hover{
    background:#c82333;
}
</style>
</head>
<body>

<h2>
    <i class="bi bi-bag-check"></i> Mes commandes
    <span class="badge" id="messagesBadge">{{ $messagesNonLus }}</span>
</h2>

<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Rechercher un produit...">
    <button type="button" onclick="filterTable()"><i class="bi bi-search"></i></button>
</div>

@if($commandes->isEmpty())
    <div class="no-orders">
        <i class="bi bi-cart-x" style="font-size:25px;"></i><br><br>
        Vous n'avez passé aucune commande pour le moment.
    </div>
@else
<div class="table-container">
    <table id="ordersTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Produits</th>
                <th>Quantité</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
            <tr>
                <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $commande->name }}</td>
                <td>{{ $commande->telephone }}</td>

                <td>
                    @foreach($commande->details as $detail)
                    <div class="product-wrapper">
                        @if($detail->produit)
                            <img src="{{ asset('storage/' . $detail->produit->image) }}" alt="{{ $detail->produit->name }}">
                            <span>{{ $detail->produit->name }}</span>
                        @else
                            <span>Produit indisponible</span>
                        @endif
                    </div>
                    @endforeach
                </td>

                <td>
                    @foreach($commande->details as $detail)
                        <div>{{ $detail->quantite }}</div>
                    @endforeach
                </td>

                <td>
                    <span class="status status-{{ Str::slug($commande->statut,'') }}" id="badge-{{ $commande->id }}">
                        {{ ucfirst($commande->statut) }}
                    </span>
                    <div id="msg-{{ $commande->id }}" style="font-size:13px; margin-top:3px; color:
                        {{ $commande->statut == 'en attente' ? '#856404' : ($commande->statut == 'confirmée' ? '#155724' : '#004085') }}">
                        @if($commande->statut == 'en attente')
                            Votre commande est en attente de traitement.
                        @elseif($commande->statut == 'confirmée')
                            Votre commande est confirmée. Vous serez contacté pour la livraison.
                        @elseif($commande->statut == 'livrée')
                            Votre commande a été livrée. Merci pour votre confiance !
                        @endif
                    </div>
                </td>

                <td>
                    <form action="{{ route('client.commande.supprimer', $commande->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete"><i class="bi bi-trash"></i> Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<script>
// Recherche
function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const table = document.getElementById("ordersTable");
    if (!table) return;

    const trs = table.getElementsByTagName("tr");
    for (let i = 1; i < trs.length; i++) {
        let tds = trs[i].getElementsByTagName("td");
        if (tds.length > 1) {
            let productText = tds[3].innerText.toLowerCase();
            trs[i].style.display = productText.includes(input) ? "" : "none";
        }
    }
}

// Mise à jour des statuts AJAX
document.addEventListener('DOMContentLoaded', function(){
    const commandesIds = @json($commandes->pluck('id'));

    function updateBadge(commandeId){
        fetch(`/client/commande/statut/${commandeId}`)
        .then(res => res.json())
        .then(data => {
            if(data.statut){
                const badge = document.getElementById(`badge-${commandeId}`);
                const msg = document.getElementById(`msg-${commandeId}`);
                const statut = data.statut.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

                badge.classList.remove('status-enattente','status-confirmee','status-livree');

                if(statut == 'enattente'){
                    badge.classList.add('status-enattente');
                    badge.innerText = 'En attente';
                    msg.innerText = 'Votre commande est en attente de traitement.';
                    msg.style.color = '#856404';
                } else if(statut == 'confirmee'){
                    badge.classList.add('status-confirmee');
                    badge.innerText = 'Confirmée';
                    msg.innerText = 'Votre commande est confirmée. Vous serez contacté pour la livraison.';
                    msg.style.color = '#155724';
                } else if(statut == 'livree'){
                    badge.classList.add('status-livree');
                    badge.innerText = 'Livrée';
                    msg.innerText = 'Votre commande a été livrée. Merci pour votre confiance !';
                    msg.style.color = '#004085';
                }
            }
        })
        .catch(err => console.error(err));
    }

    // Vérifie toutes les 5 secondes
    setInterval(() => {
        commandesIds.forEach(id => updateBadge(id));
        // badge global
        fetch('{{ route("client.messages.non-lus") }}')
        .then(res=>res.json())
        .then(data=>{
            const badge = document.getElementById('messagesBadge');
            if(badge) badge.innerText = data.count;
        });
    }, 5000);
});
</script>

</body>
</html>
</x-app-layout>