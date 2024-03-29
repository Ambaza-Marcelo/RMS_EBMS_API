<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable = [
    	'country_name',
    	'city',
    	'district'
    ];


    public function userAddress(){
    	return $this->hasMany('App\Models\UserAddress','address_id');
    }
    //supplier has many address

    public function supplier(){
    	return $this->hasMany('App\Models\Supplier','address_id');
    }

    //employes has many address

    public function employe(){
        return $this->hasMany('App\Models\Employe','address_id');
    }
}
