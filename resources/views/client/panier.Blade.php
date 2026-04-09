{{-- resources/views/client/panier.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier TUASAL</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background:#DFF5E3; color:#1f2937; padding:20px; }
        h2 { color:#556B2F; margin-bottom:20px; }
        table { width:100%; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; }
        th, td { padding:12px; text-align:left; border-bottom:1px solid #eee; vertical-align: middle; }
        th { background:#3b71ca; color:#fff; }
        table img { width:60px; height:60px; object-fit:cover; border-radius:6px; }
        .btn-supprimer { background:#f68b1e; color:#fff; padding:6px 10px; border:none; border-radius:6px; cursor:pointer; }
        .btn-supprimer:hover { background:#e07c17; }
        .btn-envoyer { background:#28a745; color:white; padding:10px 15px; border:none; border-radius:6px; cursor:pointer; font-size:16px; }
        .btn-envoyer i { margin-right:5px; }
        input { padding:6px; width:200px; margin-bottom:10px; border-radius:4px; border:1px solid #ccc; }
        /* Modal */
        .modal { display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.5); }
        .modal-content { background:#fff; margin:15% auto; padding:20px; border-radius:8px; width:90%; max-width:400px; text-align:center; position:relative; }
        .close { position:absolute; top:10px; right:15px; font-size:20px; cursor:pointer; }
    </style>
</head>
<body>

<h2>Mon Panier</h2>

@if(!$panier || count($panier) === 0)
    <p>Votre panier est vide.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($panier as $id => $item)
                @php $total += $item['prix'] * $item['quantite']; @endphp
                <tr>
                    <td>
                        <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['name'] }}">
                        {{ $item['name'] }}
                    </td>
                    <td>{{ number_format($item['prix'],0,'',' ') }} FCFA</td>
                    <td>{{ $item['quantite'] }}</td>
                    <td>{{ number_format($item['prix'] * $item['quantite'],0,'',' ') }} FCFA</td>
                    <td>
                        <form action="{{ url('client/panier/supprimer/'.$id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')

    <button type="submit" style="border:none;background:none;color:red;cursor:pointer;">
        Supprimer
    </button>
</form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:right; font-weight:bold;">Total :</td>
                <td colspan="2" style="font-weight:bold;">{{ number_format($total,0,'',' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    @if(Auth::check())
        <!-- Utilisateur connecté : envoi direct -->
        <form action="{{ route('panier.commander') }}" method="POST" style="margin-top:20px;">
            @csrf
            <button type="submit" class="btn-envoyer">
                <i class="fas fa-paper-plane"></i> Passer la commande
            </button>
        </form>
    @else
        <!-- Utilisateur non connecté : ouvrir modal -->
        <button id="openModal" class="btn-envoyer" style="margin-top:20px;">
            <i class="fas fa-paper-plane"></i> Passer la commande
                   
        </button>
    @endif
@endif

{{-- Modal pour invité --}}
<div id="modalForm" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h3>Veuillez renseigner vos informations</h3>
        <form action="{{ route('panier.commander') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Nom (facultatif)">
            <input type="text" name="telephone" placeholder="Téléphone *" required>
            <br>
            <button type="submit" class="btn-envoyer">
                <i class="fas fa-paper-plane"></i> Envoyer
            </button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('modalForm');
    const openBtn = document.getElementById('openModal');
    const closeBtn = document.getElementById('closeModal');

    if(openBtn) openBtn.onclick = () => { modal.style.display = 'block'; }
    if(closeBtn) closeBtn.onclick = () => { modal.style.display = 'none'; }
    window.onclick = (e) => { if(e.target == modal) modal.style.display = 'none'; }
</script>

</body>
</html>