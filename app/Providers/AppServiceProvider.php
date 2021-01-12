<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View::share('statistics', $statistics);
        View::composer(['backend.*'],function($view){
            $end_time = now()->addMinutes(10);
            Cache::flush();
            $statistics = Cache::remember('statistics', $end_time, function(){
                return [
                    'waiting_order' => Order::where('status','Siparişiniz alındı')->count(),
                    'completed_order' => Order::where('status','Sipariş Tamamlandı')->count(),
                    'total_order' => Order::count(),
                    'total_product' => Product::count(),
                    'total_user' => User::count()
                ];
            });
            $view->with('statistics', $statistics);
        });
        /*foreach(Setting::all() as $setting){
            Config::set('setting.'.$setting->key, $setting->value);
        }*/
    }
}
