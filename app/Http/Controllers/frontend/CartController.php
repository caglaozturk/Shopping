<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\CartProduct;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(){
        $all_categories = Category::all();
        return view('frontend.shopping-cart',compact('all_categories'));
    }
    public function add(){
        $product = Product::find(request('id'));
        $cartItem = Cart::add($product->id, $product->product_name, 1 , $product->price, 0, ['slug' => $product->slug]);
        //auth()->check() : Bir kullanıcı girişi yapıldıysa
        if(auth()->check()){
            $active_cart_id = session('active_cart_id');
            if(!isset($active_cart_id)){
                $active_cart = ShoppingCart::create([
                    'user_id' => auth()->id()
                ]);
                $active_cart_id = $active_cart->id;

                session()->put('active_cart_id', $active_cart_id);
            }
            CartProduct::updateOrCreate(
                ['cart_id' => $active_cart_id, 'product_id' => $product->id],
                ['piece' => $cartItem->qty, 'price' => $product->price, 'status' => 'Beklemede']
            );
        }

        return redirect()->route('shopping_cart')
                        ->with('message', 'Ürün Sepete Eklendi')
                        ->with('message_type', 'success');
    }
    public function remove($rowid){
        if(auth()->check()){
            $active_cart_id = session('active_cart_id');
            $cartItem = Cart::get($rowid);
            CartProduct::where('cart_id', $active_cart_id)->where('product_id', $cartItem->id)->delete();
        }
        Cart::remove($rowid);
        return redirect()->route('shopping_cart')
                        ->with('message', 'Ürün Sepetten Kaldırıldı')
                        ->with('message_type', 'success');
    }
    public function destroy(){
        if(auth()->check()){
            $active_cart_id = session('active_cart_id');
            CartProduct::where('cart_id', $active_cart_id)->delete();
        }

        Cart::destroy();
        return redirect()->route('shopping_cart')
                    ->with('message', 'Tüm ürünler Sepetten Kaldırıldı')
                    ->with('message_type', 'success');
    }
    public function update($rowid){
        $piece = request('piece');
        $validator = Validator::make(request()->all(), [
            'piece' => 'required|numeric|between:0,10'
        ]);

        if ($validator->fails()) {
            session()->flash('message','Adet değeri 0 ile 10 arasında olmalıdır');
            session()->flash('message_type','danger');

            return response()->json(['success' => false]);
        }
        if(auth()->check()){
            $active_cart_id = session('active_cart_id');
            $cartItem = Cart::get($rowid);
            if($piece == 0)     CartProduct::where('cart_id', $active_cart_id)->where('product_id', $cartItem->id)->delete();
            else    CartProduct::where('cart_id', $active_cart_id)->where('product_id', $cartItem->id)->update(['piece' => $piece]);
        }
        Cart::update($rowid, $piece);
        return response()->json(['success' => true]);
    }
}
