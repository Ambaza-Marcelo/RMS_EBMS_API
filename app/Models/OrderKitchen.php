<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderKitchen extends Model
{
    //
    protected $fillable = [
        'date',
        'commande_no',
        'employe_id',
        'status',
        'table_no',
        'auteur',
        'article_id',
        'quantity',
        'total_value',
        'description'
    ];

    public function employe(){
        return $this->belongsTo('App\Models\Employe');
    }
}
