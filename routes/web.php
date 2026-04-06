<?php
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\CommandeAdminController;
use App\Http\Controllers\CommandeClientController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Tableau de bord admin
    Route::get('admin/bord', [AdminController::class, 'index'])->name('admin.bord');

    // Gestion des rôles
    Route::get('admin/liste_client', [RoleController::class, 'index'])->name('liste_client');
    Route::get('admin/edit_role/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('admin/gestion_role/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('admin/delete/{id}', [RoleController::class,'delete'])->name('supprimer');
 });

// Route::middleware(['auth','role:admin'])->group(function() {

    // Liste des catégories
    Route::get('admin/categorie/liste_categorie', [CategorieController::class,'affiche'])->name('liste_categorie');

    Route::get('/categories/{id}', [CategorieController::class, 'show'])->name('categories.show');

    // Formulaire création
    Route::get('admin/categorie/form_categorie', [CategorieController::class,'form'])->name('categories.create');

    // Sauvegarde catégorie
    Route::post('admin/categorie/store', [CategorieController::class,'create'])->name('categories.store');

    // Formulaire édition
    Route::get('admin/categorie/edit/{id}', [CategorieController::class,'edit'])->name('categories.edit');

    // Mise à jour
    Route::put('admin/categorie/update/{id}', [CategorieController::class,'update'])->name('categories.update');

    // Suppression
    Route::delete('admin/categorie/delete/{id}', [CategorieController::class,'delete'])->name('categories.delete');

// Route pour afficher une catégorie avec ses produits
Route::get('/categories/{id}', [CategorieController::class, 'show'])->name('categories.show');
// });


// Liste des produits
Route::get('/admin/produit/liste_produit', [ProduitController::class, 'index'])->name('liste_produit');

// Formulaire ajout produitS
Route::get('/admin/produits/create', [ProduitController::class, 'create'])->name('form_produit');

// Enregistrer produit
Route::post('/admin/produits/store', [ProduitController::class, 'store'])->name('produit_store');

// Modifier produit (formulaire)
Route::get('/admin/produits/edit/{id}', [ProduitController::class, 'edit'])->name('edit_produit');

// Mise à jour produit
Route::put('/admin/produits/update/{id}', [ProduitController::class, 'update'])->name('produit_update');

// Supprimer produit
Route::delete('/admin/produits/delete/{id}', [ProduitController::class, 'destroy'])->name('produit_delete');

// Voir un produit
// Route::get('/produits/{id}', [ProduitController::class, 'show'])->name('produit.show');
Route::get('/admin/produit/{id}', [ProduitController::class,'show'])->name('produit_show');

Route::get('/admin/commandes', [AdminController::class, 'listeCommandes'])->name('commandes');
//  Route::get('/admin/commandes', [AdminController::class, 'listeCommandes'])->name('commandes');
    Route::delete('/admin/commandes/{id}', [AdminController::class, 'supprimerCommande'])->name('commandes.supprimer');
    Route::put('/admin/commandes/{id}/statut',[AdminController::class,'changerStatut'])->name('commandes.changerStatut');

     Route::get('/admin/commandes/non-lues/count', [AdminController::class, 'nombreCommandesNonLues'])
        ->name('admin.commandesNonLues');
        Route::get('/admin/commandes/non-lues/count', [App\Http\Controllers\AdminController::class, 'nombreCommandesNonLues'])
        ->name('admin.commandes.non-lues.count');



Route::middleware(['auth', 'role:client'])->group(function () {

    // Bord client
    Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');

    // AJAX : Nombre de messages non lus (pour le badge)
    Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.nombreMessagesNonLus');

    // Liste des commandes
    Route::get('/client/commandes', [ClientController::class, 'listeCommande'])
        ->name('liste_commande');

    // Produits par catégorie
    Route::get('/produits/categorie/{id}', [ClientController::class, 'produitParCategorie'])
        ->name('produits.categorie');
});


Route::middleware(['auth', 'role:client'])->group(function () {

    // Tableau de bord client
    Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');

    // AJAX : Nombre de messages non lus
    Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.nombreMessagesNonLus');

    // Liste des commandes
    Route::get('/client/commandes', [ClientController::class, 'listeCommande'])
        ->name('client.listeCommande');

    // Produits par catégorie
    Route::get('/produits/categorie/{id}', [ClientController::class, 'produitParCategorie'])
        ->name('produits.categorie');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');

    // <-- Route nécessaire pour le badge messages non lus
    Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.nombreMessagesNonLus');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');
    Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.nombreMessagesNonLus');
    Route::get('/client/produit/{id}', [ClientController::class, 'show'])->name('client.showProduit');
});
// routes/web.php


Route::middleware(['auth', 'role:client'])->prefix('client')->group(function() {
    Route::get('/bord_client', [ClientController::class, 'bord'])->name('client_bord');
    Route::get('/produit/{id}', [ClientController::class, 'show'])->name('client.showProduit');

    // AJOUTER CETTE ROUTE pour le badge AJAX
    Route::get('/nombreMessagesNonLus', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.nombreMessagesNonLus');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');
    Route::get('/client/accueil', [ClientController::class, 'accueil'])->name('client.accueil');
    Route::get('/client/produit/{id}', [ClientController::class, 'show'])->name('client.showProduit');
    Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])->name('client.nombreMessagesNonLus');
    Route::post('/client/messages/lus', [ClientController::class, 'marquerMessagesLus'])->name('client.marquerMessagesLus');
});

Route::middleware(['auth', 'role:client'])->group(function () {

    // Tableau de bord client
    Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');

    // Nombre de messages non lus (AJAX)
    Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.nombreMessagesNonLus');

    // Marquer messages comme lus
    Route::post('/client/messages/lus', [ClientController::class, 'marquerMessagesLus'])
        ->name('client.marquerMessagesLus');

    // Liste commandes client
    Route::get('/client/commandes', [ClientController::class, 'listeCommande'])
        ->name('client.listeCommande');
});

// Ajouter un produit au panier (tout utilisateur connecté)
Route::post('/client/panier/ajouter/{id}', [PanierController::class, 'ajouter'])
    ->name('panier.ajouter')
    ->middleware('auth'); // plus de role:client

// Voir le panier
Route::get('/client/panier', [PanierController::class, 'index'])
    ->name('panier.index')
    ->middleware('auth'); 

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');

    // <— cette ligne est cruciale
    Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.nombreMessagesNonLus');
});

// Badge messages non lus (AJAX)
Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
    ->name('client.nombreMessagesNonLus');

// Bord client
Route::get('/client/bord', [ClientController::class, 'bord'])->name('client.bord');

// Liste commandes
Route::get('/client/commandes', [ClientController::class, 'listeCommande'])->name('liste_commande');

// Ajouter au panier
Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');

// Afficher produits par catégorie
Route::get('/produits/categorie/{id}', [ClientController::class, 'produitParCategorie'])->name('produits.categorie');


// Nombre de commandes non lues (AJAX pour badge)
Route::get('/admin/commandes/non-lues/count', [AdminController::class, 'nombreMessagesNonLus'])
    ->name('admin.commandes.non-lues.count');

// Changer statut commande via AJAX
Route::put('/admin/commandes/{id}/changer-statut', [AdminController::class, 'changerStatutAjax'])
    ->name('admin.commandes.changerStatutAjax');

    Route::get('/commandes', [CommandeAdminController::class, 'index'])->name('admin.commandes');


    // Route AJAX pour mettre à jour le statut
    Route::put('/commandes/{id}/ajax', [CommandeAdminController::class, 'updateStatusAjax'])->name('admin.commandes.ajax');


Route::prefix('admin')->group(function(){
    Route::get('/commandes', [AdminController::class,'listeCommandes'])->name('commandes');
    Route::delete('/commandes/{id}/supprimer', [AdminController::class,'supprimerCommande'])->name('commandes.supprimer');
    Route::put('/commandes/{id}/changer-statut-ajax', [AdminController::class,'changerStatutAjax'])->name('commandes.changer.statut.ajax');
    Route::get('/commandes/non-lues', [AdminController::class,'nombreCommandesNonLues'])->name('admin.commandes.non-lues');
});


Route::get('/commandes', [CommandeAdminController::class,'index'])->name('admin.commandes');
Route::delete('/commandes/{id}', [CommandeAdminController::class,'supprimer'])->name('commandes.supprimer');
Route::put('/commandes/{id}/ajax', [CommandeAdminController::class,'updateStatusAjax'])->name('commandes.update.ajax');
Route::get('/commandes/non-lues/count', [CommandeAdminController::class,'nombreCommandesNonLues'])->name('admin.commandes.non-lues.count');


Route::get('/admin/commandes', [CommandeAdminController::class, 'index'])->name('admin.commandes');
Route::put('/admin/commandes/{id}/changer-statut-ajax', [CommandeAdminController::class, 'updateStatusAjax']);
Route::delete('/admin/commandes/{id}/supprimer', [CommandeAdminController::class, 'supprimer'])->name('commandes.supprimer');
Route::get('/admin/commandes/non-lues', [CommandeAdminController::class, 'nombreCommandesNonLues'])->name('admin.commandes.non-lues');

Route::prefix('admin')->group(function(){

    Route::get('/commandes', [CommandeAdminController::class,'index'])->name('admin.commandes');

    Route::delete('/commandes/{id}', [CommandeAdminController::class,'supprimer'])->name('commandes.supprimer');

    Route::put('/commandes/{id}/changer-statut-ajax', [CommandeAdminController::class,'updateStatusAjax'])
        ->name('admin.commandes.changer-statut-ajax');

    // Badge commandes non lues
    Route::get('/commandes/non-lues', [CommandeAdminController::class,'nombreCommandesNonLues'])
        ->name('admin.commandes.non-lues');
});


Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/bord', [AdminController::class, 'index'])->name('bord');

    Route::get('/commandes', [AdminController::class, 'listeCommandes'])->name('commandes');
    Route::delete('/commandes/{id}', [AdminController::class, 'supprimerCommande'])->name('commandes.supprimer');

    Route::put('/commandes/{id}/ajax', [AdminController::class, 'changerStatutAjax'])->name('commandes.ajax');
    Route::get('/commandes/non-lues/count', [AdminController::class, 'nombreCommandesNonLues'])->name('commandes.non-lues.count');

    // Optionnel : marquer comme lue
    Route::put('/commandes/{id}/lue', [AdminController::class, 'marquerCommeLue'])->name('commandes.marquer.lue');
});


Route::get('/recherche-produits', [App\Http\Controllers\ProduitController::class, 'recherche']);

// Page d'accueil publique (tout le monde peut voir)

Route::get('/', [ClientController::class, 'accueil']);
Route::get('/produit/{id}', [ClientController::class, 'show'])->name('produit.show');

// Page produit individuel protégée (seulement client connecté)
Route::middleware(['auth','role:client'])->group(function() {
Route::get('client/bord_client', [ClientController::class, 'bord'])->name('client_bord');

Route::get('/client/categorie_client', [ClientController::class, 'index'])->name('categorie_client');

Route::get('/client/categorie/{id}', [ClientController::class, 'produitParCategorie'])->name('produits.categorie');
  
// Marquer les messages lus
    Route::post('/client/messages/lus', [ClientController::class, 'marquerMessagesLus'])->name('client.marquerMessagesLus');

    // // Nombre messages non lus (AJAX)
    // Route::get('/client/messages/non-lus/count', [ClientController::class, 'nombreMessagesNonLus'])
    //     ->name('client.nombreMessagesNonLus');

    // Route::get('/client/commandes/non-lues', [ClientController::class, 'commandesNonLues'])->name('client.commandesNonLues');
    // Route::get('/client/nombre-messages-non-lus', [ClientController::class, 'nombreMessagesNonLus'])->name('client.nombreMessagesNonLus');

    // // Liste des commandes non lues (page)
    // Route::get('/client/commandes/non-lues', [ClientController::class, 'commandesNonLues'])
    //     ->name('client.commandesNonLues');

    //     Route::post('/client/marquer-messages-lus', [ClientController::class, 'marquerMessagesLus'])
    //     ->name('client.marquerMessagesLus');

    // Route::get('/client/messages-non-lus', [ClientController::class, 'nombreMessagesNonLus'])
    //     ->name('client.messagesNonLus');



// Liste de toutes les commandes du client
Route::get('/client/commandes', [ClientController::class, 'listeCommande'])->name('client.commandes');

// Supprimer une commande
Route::delete('/client/commande/{id}/supprimer', [ClientController::class, 'supprimer'])->name('client.commande.supprimer');

// Récupérer le statut d'une commande (AJAX)
Route::get('/client/commande/statut/{id}', [ClientController::class, 'getStatut'])->name('client.commande.statut');

// Nombre de commandes non lues (AJAX pour badge)
Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])->name('client.messages.non-lus');


    Route::middleware(['auth','role:client'])->group(function() {

    // Tableau de bord client
    Route::get('client/bord_client', [ClientController::class, 'bord'])->name('client_bord');

    // Page produit par catégorie
    Route::get('/client/categorie_client', [ClientController::class, 'index'])->name('categorie_client');
    Route::get('/client/categorie/{id}', [ClientController::class, 'produitParCategorie'])->name('produits.categorie');

    // Commandes du client
    Route::get('/client/commandes/non-lues', [ClientController::class, 'commandesNonLues'])
        ->name('client.commandesNonLues');

    // Marquer les messages comme lus
    Route::post('/client/messages/lus', [ClientController::class, 'marquerMessagesLus'])
        ->name('client.marquerMessagesLus');

    // Récupérer le nombre de messages non lus (AJAX)
    Route::get('/client/messages/non-lus/count', [ClientController::class, 'nombreMessagesNonLus'])
        ->name('client.messagesNonLus');  // ✅ nom correct utilisé dans Blade

    // Ajouter au panier
    Route::post('/client/panier/ajouter/{produitId}', [ClientController::class, 'ajouterPanier'])
        ->name('panier.ajouter');
});

    // Route AJAX pour ajouter un produit au panier
    Route::post('/client/panier/ajouter/{produitId}', [ClientController::class, 'ajouterPanier'])
        ->name('panier.ajouter');
});

Route::get('/client/commande/statut/{id}', [ClientController::class, 'getStatut'])->name('client.commande.statut');
// route pour vérifier le statut d'une commande
Route::get('/commande/statut/{id}', [App\Http\Controllers\ClientController::class, 'getStatut'])->name('commande.statut');
Route::put('/admin/commandes/{id}/changer-statut', [App\Http\Controllers\AdminController::class, 'changerStatutAjax'])->name('admin.commandes.statut.ajax');


Route::get('/commande/statut/{id}', [App\Http\Controllers\AdminController::class, 'getStatut']);
Route::put('/admin/commandes/{id}/statut', [App\Http\Controllers\AdminController::class, 'changerStatutAjax'])->name('commandes.changerStatut');
Route::delete('/admin/commandes/{id}', [App\Http\Controllers\AdminController::class, 'supprimerCommande'])->name('commandes.supprimer');




Route::get('/client/messages/non-lus', [ClientController::class, 'messagesNonLus'])
    ->name('client.messages.non-lus')
    ->middleware('auth');



Route::get('/panier', [PanierController::class, 'index'])->name('panier');
Route::post('/panier/ajouter/{id}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::get('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
// 🔴 Ajoute cette route POST pour envoyer le panier
Route::post('/panier/envoyer', [PanierController::class, 'envoyer'])->name('panier.envoyer');

Route::middleware(['auth'])->group(function() {
    Route::middleware(['auth'])->group(function() {
    // Afficher la liste des commandes
    Route::get('/liste_commande_client', [CommandeClientController::class, 'mesCommandes'])
        ->name('liste_commande');
        Route::get('/commande/supprimer/{id}', [CommandeClientController::class, 'supprimer'])->name('supprimer');

    // Passer une commande depuis le panier
    Route::post('/panier/commander', [CommandeClientController::class, 'passerCommande'])
        ->name('panier.commander');
        
});


Route::middleware('auth')->group(function () {

    // Page liste des commandes
    Route::get('/client/mes-commandes', [CommandeClientController::class, 'mesCommandes'])->name('liste_commande');

    // Supprimer une commande
    Route::delete('/client/commande/supprimer/{id}', [CommandeClientController::class, 'supprimer'])->name('client.commande.supprimer');

    // AJAX : récupérer le nombre de commandes non lues (pour badge)
    Route::get('/client/messages/non-lus', [CommandeClientController::class, 'nombreMessagesNonLus'])->name('client.messages.non-lus');

    // AJAX : récupérer le statut d'une commande
    Route::get('/client/commande/statut/{id}', [CommandeClientController::class, 'getStatut']);
});

Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
    ->name('client.messages.non-lus')
    ->middleware('auth');
// Page d'accueil client avec tous les produits
Route::get('/client', [ClientController::class, 'accueil'])
    ->name('client.accueil')
    ->middleware('auth');

// Page produit individuel
Route::get('/client/produit/{id}', [ClientController::class, 'show'])
    ->name('client.show_produit')
    ->middleware('auth');

// Tableau de bord client
Route::get('/client/bord', [ClientController::class, 'bord'])
    ->name('client.bord')
    ->middleware('auth');

// Liste des produits par catégorie
Route::get('/client/categorie/{id}', [ClientController::class, 'produitParCategorie'])
    ->name('client.produit_par_categorie')
    ->middleware('auth');

// Marquer les messages comme lus (AJAX)
Route::post('/client/messages/marquer-lus', [ClientController::class, 'marquerMessagesLus'])
    ->name('client.marquer_messages_lus')
    ->middleware('auth');

// Nombre de messages non lus (AJAX pour badge)
Route::get('/client/messages/non-lus', [ClientController::class, 'nombreMessagesNonLus'])
    ->name('client.nombreMessagesNonLus')
    ->middleware('auth');

// Liste des commandes du client
Route::get('/client/commandes', [ClientController::class, 'listeCommande'])
    ->name('client.liste_commande')
    ->middleware('auth');

// Gestion du panier

// Voir le panier
Route::get('/client/panier', [PanierController::class, 'index'])
    ->name('panier.index')
    ->middleware('auth');

// Ajouter un produit au panier
Route::post('/client/panier/ajouter/{id}', [PanierController::class, 'ajouter'])
    ->name('panier.ajouter')
    ->middleware('auth');

// Supprimer un produit du panier
Route::delete('/client/panier/supprimer/{id}', [PanierController::class, 'supprimer'])
    ->name('panier.supprimer')
    ->middleware('auth');

// Passer le panier en commande
Route::post('/client/panier/commander', [PanierController::class, 'commander'])
    ->name('panier.commander')
    ->middleware('auth');

// Page liste des commandes
Route::get('/client/mes-commandes', [CommandeClientController::class, 'mesCommandes'])
    ->name('liste_commande')
    ->middleware('auth');

// Supprimer une commande
Route::delete('/client/commande/supprimer/{id}', [CommandeClientController::class, 'supprimer'])
    ->name('client.commande.supprimer')
    ->middleware('auth');

// Badge messages non lus (AJAX)
Route::get('/client/messages/non-lus', [CommandeClientController::class, 'messagesNonLus'])
    ->name('client.messages.non-lus')
    ->middleware('auth');

    //MAIL
   Route::post('/commande', [CommandeClientController::class, 'passerCommande'])
    ->name('panier.commander');

    Route::get('/test-mail', function () {
    Mail::raw('Test email depuis Laravel', function ($message) {
        $message->to('tchadagnogo@gmail.com')
                ->subject('Test Mail');
    });

    return 'Email envoyé';
});
Route::put('/admin/commandes/{id}/changer-statut-ajax', [AdminController::class, 'changerStatutAjax'])
    ->name('admin.commandes.changerStatutAjax');

    Route::get('/client/commandes/statuts', [ClientController::class, 'statutsCommandes'])
    ->name('client.commandes.statuts');


    /// Wathssap

Route::get('/admin/commande/whatsapp/{id}', [AdminController::class, 'whatsappCommande'])
    ->name('admin.commande.whatsapp');
});
/// AVIS

Route::get('/avis', [AvisController::class, 'index']);
// Route::post('/avis', [AvisController::class, 'store']);

Route::get('/admin/avis', [AvisController::class, 'adminIndex']);
Route::delete('/admin/avis/{id}', [AvisController::class, 'destroy']);
Route::post('/avis', [AvisController::class, 'store'])->middleware('auth');
require __DIR__.'/auth.php';        

