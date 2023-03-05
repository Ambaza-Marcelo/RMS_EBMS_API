<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockoutDetail extends Model
{
    //
     protected $fillable = [
    	'date',
    	'article_id',
        'bon_no',
    	'unit',
        'created_by',
        'asker',
        'bon_no',
    	'observation',
        'total_value',
        'entree_no',
    ];

    public function article(){
    	return $this->belongsTo('App\Models\Article');
    }

}
