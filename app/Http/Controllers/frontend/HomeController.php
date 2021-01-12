<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        $all_categories = Category::all();
        $categories = Category::whereRaw('parent_id is null')->take(5)->get();

        $product_slider = ProductDetail::with('product')->where('show_slider',1)->take(5)->get();
        //Günün Fırsatı olan Ürün
        $todays_product = Product::select('product.*')
                                    ->join('product_detail','product_detail.product_id','product.id')
                                    ->where('product_detail.show_today_chance',1)
                                    ->orderBy('updated_at','desc')
                                    ->first();
        
        $urunler_one_cikan = ProductDetail::with('product')->where('show_featured',1)->take(5)->get();
        $urunler_cok_satan = ProductDetail::with('product')->where('show_bestseller',1)->take(5)->get();
        $urunler_indirimli = ProductDetail::with('product')->where('show_discount',1)->take(5)->get();

        return view('frontend.index',compact('categories','product_slider','all_categories'));
        // config('setting.slider');
        // get_setting('slider');
    }
}

