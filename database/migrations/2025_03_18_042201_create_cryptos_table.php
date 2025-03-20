<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('cryptos', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('symbol');
        $table->decimal('price', 18, 8); // Para almacenar el precio con decimales
        $table->decimal('percent_change', 5, 2);
        $table->decimal('volume', 18, 2); // Para almacenar el volumen
        $table->timestamp('created_at')->useCurrent();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('cryptos');
}

};
