<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable=[
    	'name',
    	'mail',
    	'phone_no',
    	'address_id'
    ];

    public function address(){
    	return $this->belongsTo('App\Models\Address');
    }

    public function order(){
    	return $this->hasMany('App\Models\Order','supplier_id');
    }

    public function fuelOrder(){
        return $this->hasOne('App\Models\FuelOrder','supplier_id');
    }

    public function fuelOrderDetail(){
        return $this->hasOne('App\Models\FuelOrderDetail','supplier_id');
    }

    public function fuelReceptionDetail(){
        return $this->hasOne('App\Models\FuelReceptionDetail','supplier_id');
    }

    public function fuelReception(){
        return $this->hasOne('App\Models\FuelReception','supplier_id');
    }
}
