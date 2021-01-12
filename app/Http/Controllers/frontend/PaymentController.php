<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaymentController extends Controller
{
    public function index(){
        if(!auth()->check()){
            return redirect()->route('login')
                            ->with('message_type','info')
                            ->with('message','Ödeme işlemi için oturum açmanız ve kullanıcı kaydı yapmanız gerekmektedir.');
        }else if(count(Cart::content())==0){
            return redirect()->route('home')
                            ->with('message_type','info')
                            ->with('message', 'Ödeme işlemi için sepetinizde bir ürün bulunmalıdır.');
        }
        $all_categories = Category::all();
        $user_detail = auth()->user()->detail;
        return view('frontend.payment',compact('all_categories','user_detail'));
    }
    public function pay(){
        $order = request()->all();
        $order['cart_id'] = session('active_cart_id');
        $order['bank'] = "Garanti";
        $order['installment'] = 1;
        $order['status'] = "Siparişiniz alındı";
        $order['order_price'] = Cart::total();

        Order::create($order);
        Cart::destroy();
        //session()->forget: session içindeki active_cart_id'ye eşit olan sepeti temizle
        session()->forget('active_cart_id');

        return redirect()->route('orders')
            ->with('message_type', 'success')
            ->with('message', 'Ödemeniz başarılı bir şekilde gerçekleştirildi.');
    }
}
