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
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'monthly_income',
        'balance',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    protected $casts = [
        'email_verified_at' => 'datetime',

        'password' => 'hashed',
    ];
    


    public function profiles()
    {
        return $this->hasMany(Profile::class, 'user_id');
    }


    public function categories()
    {
        return $this->hasMany(Categorie::class, 'user_id');
    }
 
    public function balance()
    {
        return $this->hasOne(Balance::class, 'user_id');
    }

    public function goals()
{
    return $this->hasMany(Goal::class);
}
}
