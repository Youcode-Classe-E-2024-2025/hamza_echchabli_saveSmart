<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model

{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['title', 'type_id', 'user_id'];


    public function transactions(){



        return $this->hasMany(Transaction::class, 'categorie_id');




    } 

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }




}
