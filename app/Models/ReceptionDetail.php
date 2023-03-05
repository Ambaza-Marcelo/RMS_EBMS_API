<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceptionDetail extends Model
{
    //
    protected $fillable = [
    	'date' ,
    	'reception_no' ,
    	'invoice_no' ,
    	'commande_no' ,
    	'supplier' ,
    	'article_id' ,
    	'quantity' ,
    	'unit' ,
    	'unit_price',
    	'total_value',
    	'remaining_quantity',
    	'created_by',
    	'description',
    	'receptionist',
    	'status' 
    ];

    public function article(){
    	return $this->belongsTo('App\Models\Article');
    }
}
