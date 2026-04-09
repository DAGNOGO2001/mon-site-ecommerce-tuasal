<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // créer rôle admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // créer utilisateur admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'DAGNOGO',
                'password' => Hash::make('12345678'),
                'telephone' => '0709089755',
            ]
        );

        // attacher rôle admin
        if (!$adminUser->roles->contains($adminRole->id)) {
            $adminUser->roles()->attach($adminRole->id);
        }
    }
}