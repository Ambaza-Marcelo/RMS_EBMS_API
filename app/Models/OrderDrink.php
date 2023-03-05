<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDrink extends Model
{
    //
    protected $fillable = [
        'date',
        'commande_no',
        'employe_id',
        'status',
        'table_no',
        'auteur',
        'description'
    ];

    public function employe(){
        return $this->belongsTo('App\Models\Employe');
    }
}
