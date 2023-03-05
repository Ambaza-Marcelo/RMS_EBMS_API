<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDrinkDetail extends Model
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

    public function article(){
        return $this->belongsTo('App\Models\Article');
    }
}
