<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    // El lo hace protected $guarded[]; pero esto es caca en produccion
    protected $fillable = [
        'name',
        'year',
        'password',
            ];
}
