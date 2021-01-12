<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        if(request()->isMethod('POST')){
            $this->validate(request(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $credentials = [
                'email'    => request()->get('email'),
                'password' => request()->get('password'),
                'is_active' => 1,
                'is_admin' => 1
            ];
            if(Auth::guard('admin')->attempt($credentials, request()->has('remember_me'))){
                return redirect()->route('admin.home');
            }else{
                //back ile tekrar forma geri dön email değeri ile geri dön 
                return back()->withInput()->withErrors(['email' => 'Giriş Hatalı']);
            }
        }
        return view('backend.login');
    }
    public function logout(){
        Auth::guard('admin')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect()->route('admin.login');
    }
    public function list(){
        $lists = User::orderByDesc('created_at')->get();
        return view('backend.user.list', compact('lists'));
    }
    public function create(){
        return view('backend.user.create');
    }
    public function update($request = 'show',$id){
        $data = User::find($id);
        return view('backend.user.update', compact('data', 'request'));
    }
    public function save($id = 0){
        $this->validate(request(), [
            'fullname' => 'required',
            'email' => 'required|email'
        ]);
        $data = request()->only('fullname', 'email');
        if(request()->filled('password')){
            $data['password'] = Hash::make(request('password'));
        }
        $data['is_active'] = (request()->has('is_active') && request('is_active')) ? 1 : 0;
        $data['is_admin'] = (request()->has('is_admin') && request('is_admin')) ? 1 : 0;
        if($id > 0){
            $entry = User::where('id', $id)->firstOrFail();
            $entry->update($data);
        }else{
            $entry = User::create($data);
        }

        $data_detail = request()->only('address','phone_number','mobile_number');
        UserDetail::updateOrCreate(
            ['user_id' => $entry->id],
            $data_detail
        );
        return redirect()
                ->route('admin.user.update', ['update',$entry->id])
                ->with('message', ($id>0 ? 'Güncellendi' : 'Kaydedildi'))
                ->with('message_type', 'success');
    }
    public function delete($id){
        User::destroy($id);
        return redirect()->route('admin.user.list')->with('message', 'Kayıt Silindi')->with('message_type', 'success');
    }
}
