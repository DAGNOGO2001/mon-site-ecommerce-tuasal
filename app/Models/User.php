<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relation Many-to-Many avec les rôles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // Vérifie si l'utilisateur a un rôle spécifique
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
    public function paniers()
{
    return $this->hasMany(Panier::class);
}
 public function commandes()
    {
        return $this->hasMany(Commande::class); // Commande = ton modèle de commande
    }
}