<?php

namespace App\Http\Controllers\backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function list(){
        $lists = Product::with('categories')->get();
        return view('backend.product.list', compact('lists'));
    }
    public function create(){
        return view('backend.product.create');
    }
    public function update($request = 'show',$id = 0){
        $data = new Product;
        $all_categories = Category::all();
        $product_category = [];
        if($id>0){
            $data = Product::find($id);
            $product_category = $data->categories()->pluck('category_id')->all();
        }
        return view('backend.product.update', compact('data', 'request', 'all_categories', 'product_category'));
    }
    public function save($id = 0){
        $data = request()->only('product_name', 'price','slug', 'description');    
        if(!request()->filled('slug')){
            $data['slug'] = str_slug(request('product_name'));
            request()->merge(['slug' => $data['slug']]);
        }   
        $this->validate(request(), [
            'product_name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'slug' => (request('original_slug') != request('slug')) ? 'unique:category,slug' : ''
        ]); 
        $data_detail = request()->only('show_slider','show_today_chance','show_featured','show_bestseller','show_discount');

        $all_categories = request('categories');

        if($id > 0){
            $entry = Product::where('id', $id)->firstOrFail();
            $entry->update($data);
            $entry->detail()->update($data_detail);
            $entry->categories()->sync($all_categories);
        }else{
            $entry = Product::create($data);
            $entry->detail()->create($data_detail);
            $entry->categories()->attach($all_categories);
        }        

        /*ProductDetail::updateOrCreate(
            ['product_id' => $entry->id],
            $data_detail
        );*/
        
        if(request()->hasFile('product_file')){
            $this->validate(request(), [
                'product_file' => 'image|mimes:jpg,png,jpeg,gif|max:2048'
            ]);
            $product_file = request()->file('product_file');
            $fileName = $entry->id . '-' . time() . $product_file->extension();
            // $fileName = $product_file->getClientOriginalName();
            // $fileName = $product_file->hashName();
            if($product_file->isValid()){
                $product_file->move('uploads/products', $fileName);
                ProductDetail::updateOrCreate(
                    ['product_id' => $entry->id],
                    ['product_image' => $fileName]
                );
            }
        }
        
        return redirect()
                ->route('admin.product.update', ['update',$entry->id])
                ->with('message', ($id>0 ? 'Güncellendi' : 'Kaydedildi'))
                ->with('message_type', 'success');
    }
    public function delete($id){
        $product = Product::find($id);
        // Detach: Many to many yapısına uygun olarak silmeyi sağlar
        $product->categories()->detach();
        //Burda direk kayıt olarak silme gerçekleştirir
        $product->detail()->delete();
        $product->delete();
        return redirect()->route('admin.product.list')->with('message', 'Kayıt Silindi')->with('message_type', 'success');
    }
}
