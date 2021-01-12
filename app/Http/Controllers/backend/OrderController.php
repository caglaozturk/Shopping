<?php

namespace App\Http\Controllers\backend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function list(){
        $lists = Order::with('cart.user')->get();
        return view('backend.order.list', compact('lists'));
    }
    public function update($request = 'show', $id){
        $data = Order::with('cart.cart_products.product')->find($id);
        return view('backend.order.update', compact('data', 'request'));
    }
    public function save($id){
        $this->validate(request(), [
            'fullname' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'status' => 'required'
        ]);
        $data = request()->only('fullname', 'phone_number', 'mobile_number', 'address', 'status');
        
        $entry = Order::where('id', $id)->firstOrFail();
        $entry->update($data);
            
        return redirect()
                ->route('admin.order.update', ['update', $entry->id])
                ->with('message', ('Güncellendi'))
                ->with('message_type', 'success');
    }
    public function delete($id){
        Order::destroy($id);
        return redirect()->route('admin.order.list')->with('message', 'Kayıt Silindi')->with('message_type', 'success');
    }
}
