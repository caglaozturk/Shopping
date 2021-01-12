@extends('frontend.layouts.master')
@section('title', 'Oturum Aç')
@section('content')
<!-- Begin Login Content Area -->
<div class="page-section mb-60">
    <div class="container">
        <div class="row" style="justify-content: center">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30">
                <!-- Login Form s-->
                @include('errors.alert')
                @include('errors.errors')
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="login-form">
                        <h4 class="login-title">Oturum Aç</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label>Email Adresi*</label>
                                <input class="mb-0" name="email" type="email" placeholder="Email Adresi">
                            </div>
                            <div class="col-12 mb-20">
                                <label>Parola</label>
                                <input class="mb-0" name="password" type="password" placeholder="Parola">
                            </div>
                            <div class="col-md-8">
                                <div class="check-box d-inline-block ml-0 ml-md-2 mt-10">
                                    <input type="checkbox" name="remember_me" id="remember_me">
                                    <label for="remember_me">Beni Hatırla</label>
                                </div>
                            </div>
                            <div class="col-md-4 mt-10 mb-20 text-left text-md-right">
                                <a href="#"> Şifremi Unuttum?</a>
                            </div>
                            <div class="col-md-12">
                                <button class="register-button mt-0">Giriş Yap</button>
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