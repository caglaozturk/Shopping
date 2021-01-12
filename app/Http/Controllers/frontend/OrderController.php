<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $all_categories = Category::all();
        $orders = Order::with('cart')
                            ->whereHas('cart',function ($query){
                                $query->where('user_id', auth()->id());
                            })
                            ->orderByDesc('updated_at')->get();
        return view('frontend.orders',compact('all_categories','orders'));
    }
    public function detail($id){
        $all_categories = Category::all();
        $order = Order::with('cart.cart_products.product')
                            ->whereHas('cart',function ($query){
                                $query->where('user_id', auth()->id());
                            })
                            ->where('orders.id', $id)->firstOrFail();
        return view('frontend.order',compact('all_categories', 'order'));
    }
}
