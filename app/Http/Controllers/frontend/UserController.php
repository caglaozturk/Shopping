<?php

namespace App\Http\Controllers\frontend;

use App\Models\User;
use App\Mail\SendMail;
use App\Models\Category;
use App\Models\CartProduct;
use Illuminate\Support\Str;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except('checkout');
    }
    public function signin_form(){
        $all_categories = Category::all();
        return view('frontend.signin',compact('all_categories'));
    }
    public function login(){
        $this->validate(request(),[
            'email' => 'required|email',            
            'password' => 'required'
        ]);
        $credentials = [
            'email'=>request('email'),
            'password'=>request('password'),
            'is_active' => 1
        ];
        if(auth()->attempt($credentials, request()->has('remember_me'))){
            request()->session()->regenerate();
            //firstOrCreate:db'de bulursa ilk kaydı al bulamazsan oluştur
            //$active_cart_id = ShoppingCart::firstOrCreate(['user_id' => auth()->id()])->id;
            $active_cart = ShoppingCart::active_cart_id();
            if(is_null($active_cart)){
                $active_cart = ShoppingCart::create([
                    'user_id' => auth()->id()
                ]);
            }            
            $active_cart_id = $active_cart->id;
            
            session()->put('active_cart_id', $active_cart_id);
            if(Cart::count()>0){
                foreach(Cart::content() as $cartItem){
                    CartProduct::updateOrCreate(
                        ['cart_id' => $active_cart_id, 'product_id' => $cartItem->id],
                        ['piece' => $cartItem->qty, 'price' => $cartItem->price, 'status' => 'Beklemede']
                    );
                }
            }

            Cart::destroy();

            $cart_products = CartProduct::with('product')->where('cart_id', $active_cart_id)->get();
            foreach($cart_products as $cart_product){
                Cart::add($cart_product->product->id, $cart_product->product->product_name, $cart_product->piece , $cart_product->product->price, 0, ['slug' => $cart_product->product->slug]);
            }

            return redirect()->intended('/');
        }else{
            $errors = ['email' => 'Hatalı Giriş'];
            return back()->withErrors($errors);
        }
    }
    public function signup_form(){
        $all_categories = Category::all();
        return view('frontend.signup',compact('all_categories'));
    }
    public function sign_up(){
        $this->validate(request(), [
            'fullname' => 'required|min:5|max:50',
            'email' => 'required|email|unique:users',            
            'password' => 'required|confirmed|max:15'
        ]);
        
        $user = User::create([
            'fullname' => request('fullname'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'activation_key' => Str::random(60),
            'is_active' => 0
        ]);
        $user->detail()->save(new UserDetail());

        Mail::to(request('email'))->send(new SendMail($user));
        
        auth()->login($user);
        return redirect()->route('home');
    }
    public function activate($key){
        $all_categories = Category::all();
        $user = User::where('activation_key', $key)->first();
        if (!is_null($user)) {
            $user->activation_key = null;
            $user->is_active = 1;
            $user->save();

            return redirect()->to('/')
                ->with('message', 'Kullanıcı kaydınız aktifleştirildi')
                ->with('message_type', 'success')
                ->with('all_categories',$all_categories);
        } else {
            return redirect()->to('/')
                ->with('message', 'Kullanıcı kaydınız aktifleştirilemedi')
                ->with('message_type', 'warning')
                ->with('all_categories',$all_categories);
        }
    }
    public function checkout(){
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('home');
    }
}
