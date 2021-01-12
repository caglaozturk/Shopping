<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoppingCart extends Model
{
    use SoftDeletes;
    
    protected $table = 'carts';
    protected $guarded = [];

    public function order(){
        return $this->hasOne('App\Models\Order');
    }

    public function cart_products()
    {
        return $this->hasMany('App\Models\CartProduct', 'cart_id', 'id');
    }

    public static function active_cart_id(){
        $active_cart_id = DB::table('carts as c')
                ->leftJoin('orders as or', 'or.cart_id', '=', 'c.id')
                ->where('c.user_id', auth()->id())
                ->whereRaw('or.id is null')
                ->orderByDesc('c.updated_at')
                ->select('c.id')
                ->first();

        if(!is_null($active_cart_id))   return $active_cart_id;
    }

    public function order_product_piece(){
        return DB::table('cart_products')->where('cart_id', $this->id)->sum('piece');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
