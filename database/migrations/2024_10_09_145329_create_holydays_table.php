<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendar_id'); // establecemos relación con calendario
            $table->foreignId('user_id'); // establecemos la relacion con los usuario 
            $table->date('day');// este campo se crear para establecer si se le concede el dia o no
            $table->enum('type', ['decline', 'approved', 'pending'])->default('pending'); // y este para establecer el estado 
            //de dicho campo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
