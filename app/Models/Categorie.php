<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model

{
    

    protected $table = 'categories';

    protected $fillable = ['title', 'user_id'];

    public function expenses(){



        return $this->hasMany(Expense::class, 'categorie_id');




    } 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    





}
