<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
    	'code',
    	'name',
        'quantity',
        'unit',
    	'unit_price',
        'expiration_date',
        'specification',
        'status',
        'created_by',
        'threshold_quantity',
    	'category_id'
    ];


     public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    //order detail has many item
    public function orderDetail(){
    	return $this->hasMany('App\Models\OrderDetail','article_id');
    }
    //stock has many items
    public function stock(){
    	return $this->hasMany('App\Models\Stock','article_id');
    }
    //stockin detail has many items
    public function stockinDetail(){
    	return $this->hasMany('App\Models\StockinDetail','article_id');
    }
    //stockout detail has many items
    public function stockoutDetail(){
    	return $this->hasMany('App\Models\StockoutDetail','article_id');
    }
    //inventory detail has many items
    public function inventoryDetail(){
        return $this->hasMany('App\Models\InventoryDetail','article_id');
    }

    public function receptionDetail(){
        return $this->hasMany('App\Models\ReceptionDetail','article_id');
    }

    public function report(){
        return $this->hasMany('App\Models\Report','article_id');
    }

    public function factureDetail(){
        return $this->hasMany('App\Models\FactureDetail','article_id');
    }

    public function factureRestaurantDetail(){
        return $this->hasMany('App\Models\FactureRestaurantDetail','article_id');
    }

}
