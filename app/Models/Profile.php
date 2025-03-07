<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'avatar' ,'active', 'archive'];

  

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'profile_id');
    }

    
}
