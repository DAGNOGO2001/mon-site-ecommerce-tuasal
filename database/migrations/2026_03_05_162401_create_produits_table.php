<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();                          // id
            $table->string('name');                // nom
            $table->text('description')->nullable(); // description
            $table->decimal('prix', 10, 2);        // prix
            $table->string('image')->nullable();   // image (chemin ou URL)
            $table->integer('stock')->default(0);  // stock
            $table->foreignId('categorie_id')      // clé étrangère vers categories
                  ->constrained()
                  ->onDelete('cascade');
            $table->timestamps();                  // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};