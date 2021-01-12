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
                        <h2>Siparişler</h2>
                        @if (count($orders) == 0)
                            <p>Henüz siparişiniz yok</p>
                        @else
                            <table class="table table-bordererd table-hover">
                                <tr>
                                    <th>Sipariş Kodu</th>
                                    <th>Tutar</th>
                                    <th>Toplam Ürün</th>
                                    <th>Durum</th>
                                    <th></th>
                                </tr>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>SP-{{ $order->id }}</td>
                                        <td>{{ $order->order_price }}</td>
                                        <td>{{ $order->cart->order_product_piece() }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td><a href="{{ route('order', $order->id) }}" class="btn btn-sm btn-success">Detay</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection