<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Teniendo en cuenta que la table de vacaciones puede tner varios usuario y varios calendarios 
// se establecerá la relación con los mismos
class Holiday extends Model
{

    // prodría hacerlo como hace el con el protected guarded pero es mejor que me acostumbre asi ya que es la practica correcta
    // para implementar en producción
    protected $fillable = [
        
        'calendar_id',
        'user_id',
        'day',
        'type',
        'updated_at',
        'created_at',
    ];

    
    
    

    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function calendar(){
        return $this->belongsTo(Calendar::class);
    }
}
