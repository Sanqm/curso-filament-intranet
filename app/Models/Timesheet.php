<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Los horarios tendran varios trabajdores y a su vez diferentes calendarios por lo que estableceramos 
//la relacióin con los mismos

class Timesheet extends Model
{
    use HasFactory;
    protected $guarded = []; // lo mismo que en los anteriores esto en producición no se hace 
    // deberiamos usar la varibale $filabe para indicar aquellos campos que serán rellenables 
    // o incluso con el hidden aquellos que no se muestran
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
