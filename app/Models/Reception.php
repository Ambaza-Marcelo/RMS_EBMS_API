<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    //
    protected $fillable = [
    	'date',
    	'reception_no',
    	'invoice_no',
    	'commande_no',
    	'supplier',
    	'receptionist',
    	'created_by',
    	'description'
    ];
}
