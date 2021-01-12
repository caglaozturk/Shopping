@extends('frontend.layouts.master')
@section('title', 'Kaydol')
@section('content')
<!-- Begin Login Content Area -->
<div class="page-section mb-60">
    <div class="container">
        <div class="row" style="justify-content: center">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                @include('errors.errors')
                <form action="{{ route('sign_up') }}" method="POST">
                    @csrf
                    <div class="login-form">
                        <h4 class="login-title">Kaydol</h4>
                        <div class="row">
                            <div class="col-12 mb-20 {{$errors->has('fullname') ? 'has-error' : ''}}">
                                <label>Adı Soyadı</label>
                                <input class="mb-0" name="fullname" type="text" value="{{ old('fullname') }}" placeholder="Adı Soyadı">
                                @if($errors->has('fullname'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('fullname')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12 mb-20 {{$errors->has('email') ? 'has-error' : ''}}">
                                <label>Email Adresi*</label>
                                <input class="mb-0" name="email" type="email" value="{{ old('email') }}" placeholder="Email Adresi">
                                @if($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('email')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-20">
                                <label>Parola</label>
                                <input class="mb-0" name="password" type="password" placeholder="Parola">
                            </div>
                            <div class="col-md-6 mb-20">
                                <label>Doğrula</label>
                                <input class="mb-0" name="password_confirmation" type="password" placeholder="Paralo">
                            </div>
                            <div class="col-12">
                                <button class="register-button mt-0">Kaydol</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login Content Area End Here -->
@endsection