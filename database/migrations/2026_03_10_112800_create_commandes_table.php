<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('commandes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->string('name')->nullable();
        $table->string('telephone')->nullable();

        $table->enum('statut', ['en attente','confirmée','livrée'])->default('en attente');
        $table->boolean('lu')->default(false);

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};      