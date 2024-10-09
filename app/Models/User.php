<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'addres',
        'postal_code'
    
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    } 

    /////relacion belongs to ya que una direccion va a pertener a un usuario 
    public function country(){
        return $this->belongsTo(Country::class);
    }

    ///// Establecemos ls relaciones con las tablas pivote
    public function calendars(){
        return $this->belongsToMany(Calendar::class); // ya que un calendario pertenence a mas de una persona
    }
    public function departaments(){
        return $this->belongsToMany(Department::class); // ya que un departamento tiene diferentes empleados
    }
    public function holidays(){
        return $this->belongsToMany(Holiday::class); // ya que varios usuarios pueden tner el mismo dia libre
    }
    public function timesheets(){
        return $this->belongsToMany(Timesheet::class); //ya que diferentes horarios pueden tener diferentes usuario 
    }
}
