<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    { // establecemos los campos union en la tabla pivote, recordemos que las mismas se crean con los id de cda 
        ///una de las tablas realacionadas
        Schema::create('table_user_calendar', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('calandar_id'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_user_calendar');
    }
};
