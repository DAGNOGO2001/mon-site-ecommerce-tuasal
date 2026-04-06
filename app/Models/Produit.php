<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'prix', 
        'image', 
        'stock', 
        'categorie_id',
        'image'
    ];

    // Relation vers Categorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function paniers()
{
    return $this->hasMany(Panier::class);
}
}