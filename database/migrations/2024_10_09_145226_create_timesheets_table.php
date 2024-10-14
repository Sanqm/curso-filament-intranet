<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Esta tabla crerá los horarios teneiendo en cuenta los descansos de las pausas y 
     * los días en los que se trabaja o no 
     * 
     */
    public function up(): void
    {
        
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendar_id');
            $table->foreignId('user_id'); 
            $table->enum('type',['work', 'pause'])->default('work'); // cremos un campo que puede tener dos valores e indicamos 
            // que en la creación es work por defecto 
            $table->timestamp('day_in'); 
            $table->timestamp('day_out'); // este y el anterior establecerán las jornadas trabajadas y descansadas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
