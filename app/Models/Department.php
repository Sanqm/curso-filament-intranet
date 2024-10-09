<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = []; // aquei lo fams a hacer asi 
    // en vez con filable dado que este recurso lo crearemos de forma manual 
    //para poder personalizarlo y ver como interactua con laravel

    
}
