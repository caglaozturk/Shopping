<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){

        $best_seller = DB::select("
            SELECT p.product_name , SUM(cp.piece) piece
            FROM orders as ord 
            INNER JOIN carts as c ON c.id = ord.cart_id
            INNER JOIN cart_products as cp ON c.id = cp.cart_id 
            INNER JOIN product as p ON p.id = cp.product_id
            GROUP BY p.product_name
            ORDER BY SUM(cp.piece) DESC
        ");
        $month_seller = DB::select("
            SELECT
                DATE_FORMAT(ord.created_at, '%Y-%m') month, sum(cp.piece) piece
            FROM orders as ord 
            INNER JOIN carts as c ON c.id = ord.cart_id
            INNER JOIN cart_products as cp ON c.id = cp.cart_id 
            GROUP BY DATE_FORMAT(ord.created_at, '%Y-%m')
            ORDER BY DATE_FORMAT(ord.created_at, '%Y-%m')
        ");
        return view('backend.index', compact('best_seller','month_seller'));
        
        // $end_time = now()->addMinutes(10);

        // $statistics = Cache::remember('statistics', $end_time, function(){
        //     return [
        //         'waiting_order' => Order::where('status','Siparişiniz alındı')->count()
        //     ];
        // });
        // return view('backend.index', compact('statistics'));

        // $cache_durum = "db";
        // if(!Cache::has('statistics')){
        //     $statistics = [
        //         'waiting_order' => Order::where('status','Siparişiniz alındı')->count(),
        //     ];
        //     $end_time = now()->addMinutes(10);
        //     Cache::put('statistics', $statistics, $end_time);
        //     //Cache::add('statistics', $statistics, $end_time);
        // }else{
        //     $statistics = Cache::get('statistics');
        //     $cache_durum = "cache";
        // }
        // //Cache temizleme
        // Cache::forget('statistics');
        // Cache::flush();
        // php artisan cache:clear
        // Cache alanında varsa cache'ten yoksa veritabanından çek
        // Cache::remember('statistics', $end_time, function(){});
    }
}
