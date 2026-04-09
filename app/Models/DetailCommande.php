<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCommande extends Model
{
    use HasFactory;

    protected $fillable = ['commande_id', 'produit_id', 'quantite', 'prix'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}