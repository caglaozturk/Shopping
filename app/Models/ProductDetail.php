<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetail extends Model
{
    protected $table = "product_detail";
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
