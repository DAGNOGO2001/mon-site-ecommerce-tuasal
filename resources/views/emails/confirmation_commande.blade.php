<!DOCTYPE html>
<html>
<head>
    <title>Confirmation commande</title>
</head>
<body>
    <h2>✅ Votre commande est bien reçue</h2>

    <p>Bonjour {{ $commande->name }},</p>

    <p>Votre commande a été enregistrée avec succès.</p>

    <p><strong>ID commande :</strong> {{ $commande->id }}</p>

    <p>Nous vous contacterons bientôt pour la suite.</p>

    <br>
    <p>Merci pour votre confiance 🙏</p>
</body>
</html>