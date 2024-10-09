<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Teniendo en cuenta que la table de vacaciones puede tner varios usuario y varios calendarios 
// se establecerá la relación con los mismos
class Holiday extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function calendar(){
        return $this->belongsTo(Calendar::class);
    }
}
