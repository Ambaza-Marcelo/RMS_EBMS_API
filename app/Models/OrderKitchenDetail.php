<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderKitchenDetail extends Model
{
    //
    protected $fillable = [
        'date',
        'article_id',
        'article_id',
        'quantity',
        'total_value',
        'description',

    ];

    public function article(){
        return $this->belongsTo('App\Models\Article');
    }
}
