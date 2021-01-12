<?php

namespace App\Http\Controllers\backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function list(){
        $lists = Category::with('parent_category')->get();
        return view('backend.category.list', compact('lists'));
    }
    public function update($request = 'show', $id = 0){
        $data = new Category;
        if($id>0)   $data = Category::find($id);
        $all_categories = Category::all();
        return view('backend.category.update', compact('data', 'all_categories', 'request'));
    }
    public function save($id = 0){
        $data = request()->only('category_name', 'slug', 'parent_id');
        if(!request()->filled('slug')){
            $data['slug'] = str_slug(request('category_name'));
            request()->merge(['slug' => $data['slug']]);
        }

        $this->validate(request(), [
            'category_name' => 'required',
            'slug' => (request('original_slug') != request('slug')) ? 'unique:category,slug' : ''
        ]);
        /*if(Category::whereSlug($data['slug'])->count()>0){
            return back()->withInput()->withErrors([['slug' => 'Slug Değeri Önceden Kayıtlıdır!...']]);
        }*/

        if($id > 0){
            $entry = Category::where('id', $id)->firstOrFail();
            $entry->update($data);
        }else{
            $entry = Category::create($data);
        }
        return redirect()
                ->route('admin.category.update', ['update',$entry->id])
                ->with('message', ($id>0 ? 'Güncellendi' : 'Kaydedildi'))
                ->with('message_type', 'success');
    }
    public function delete($id){
        // Attach: Many To many tablolarına kayıt eklemeyei sağlar
        // Detach: Many to many tablolarına kayıt silmeyi sağlar
        $category = Category::find($id);
        $category->products()->detach();
        $category->delete();    //find ile bulduğun kaydı silebilirsin
        //Category::destroy($id);
        return redirect()->route('admin.category.list')->with('message', 'Kayıt Silindi')->with('message_type', 'success');
    }
}
