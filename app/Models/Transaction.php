<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = ['title', 'amount', 'profile_id', 'categorie_id', 'type'];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
}
