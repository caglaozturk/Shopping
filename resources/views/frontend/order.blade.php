@extends('frontend.layouts.master')
@section('title', 'Siparişler')
@section('content')
<div class="checkout-area pt-30 pb-30">
    <div class="container">
        @include('errors.alert')
        <div class="row">
            <div class="col-lg-12">
                <div class="your-order">
                    <div class="bg-content">
                        <div class="row">
                            <div class="col-6">
                                <h2>Sipariş (SP-{{ $order->id }})</h2>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('orders') }}" class="btn btn-xs btn-primary float-right">
                                    <i class="glyphicon glyphicon-arrow-left"></i> Siparişlere Dön
                                </a>
                            </div>
                        </div>
                        <table class="table table-bordererd table-hover">
                            <tr>
                                <th colspan="2">Ürün</th>
                                <th>Tutar</th>
                                <th>Adet</th>
                                <th>Ara Toplam</th>
                                <th>Durum</th>
                            </tr>
                            @foreach($order->cart->cart_products as $sepet_urun)
                                <tr>
                                    <td style="width:120px">
                                        <a href="{{ route('product', $sepet_urun->product->slug) }}">
                                            <img src="/frontend/images/product/large-size/{{ $sepet_urun->product->detail->product_image }}" style="height: 120px;">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('product', $sepet_urun->product->slug) }}">
                                            {{ $sepet_urun->product->product_name }}
                                        </a>
                                    </td>
                                    <td>{{ $sepet_urun->price }} ₺</td>
                                    <td>{{ $sepet_urun->piece }}</td>
                                    <td>{{ $sepet_urun->price * $sepet_urun->piece }} ₺</td>
                                    <td>{{ $sepet_urun->status }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="4" class="text-right">Toplam Tutar</th>
                                <td colspan="2">{{ $order->siparis_tutari }} ₺</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Toplam Tutar (KDV'li)</th>
                                <td colspan="2">{{ $order->siparis_tutari* ((100+config('cart.tax'))/100) }} ₺</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Sipariş Durumu</th>
                                <td colspan="2">{{ $order->status }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection