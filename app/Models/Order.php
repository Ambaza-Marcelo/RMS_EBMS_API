<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
    	'supplier_id',
        'commande_no',
        'description',
        'status'
    ];

    public function supplier(){
    	return $this->belongsTo('App\Models\Supplier');
    }

}
