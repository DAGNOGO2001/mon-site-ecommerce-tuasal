<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['name', 'description'];

    // Une catégorie a plusieurs produits
    public function produit() {
        return $this->hasMany(Produit::class);
    }
}
