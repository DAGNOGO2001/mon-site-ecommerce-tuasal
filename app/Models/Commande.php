<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'telephone','statut'];

    // Relation avec les détails de commande
    public function details()
    {
        return $this->hasMany(DetailCommande::class);
    }

    // Relation avec l'utilisateur (client enregistré)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}