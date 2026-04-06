<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle commande</title>
</head>
<body>
    <h2>📦 Nouvelle commande reçue</h2>

    <p><strong>Commande ID :</strong> {{ $commande->id }}</p>

    <p><strong>Client :</strong> {{ $commande->name ?? 'N/A' }}</p>

    <p><strong>Téléphone :</strong> {{ $commande->telephone ?? 'N/A' }}</p>

    <p>Merci de vérifier votre tableau de bord admin.</p>
</body>
</html>