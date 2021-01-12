<?php
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if(!function_exists('get_setting')){
    function get_setting($key){
        $all_settings = Cache::rememberForever('all_settings', function () {
            return Setting::all();
        });
        return $all_settings->where('key', $key);
    }
}
