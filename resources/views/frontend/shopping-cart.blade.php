@extends('frontend.layouts.master')
@section('title', 'Siparişler')
@section('content')
<div class="Shopping-cart-area pt-30 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('errors.alert')
                @if (count(Cart::content())>0)
                    <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="li-product-remove">Sil</th>
                                        <th class="li-product-thumbnail">Resim</th>
                                        <th class="cart-product-name">Ürün</th>
                                        <th class="li-product-price">Fiyat</th>
                                        <th class="li-product-quantity">Adet</th>
                                        <th class="li-product-subtotal">Tutar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $product_cart)
                                        <tr>
                                            <td class="test">
                                                <form action="{{ route('shopping_remove', $product_cart->rowId) }}" method="post">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn" type="submit"><i class="fa fa-times"></i></button>
                                                </form>
                                            </td>
                                            <td class="li-product-thumbnail" style="width: 120px;"><a href="{{ route('product', $product_cart->options->slug) }}"><img src="/frontend/images/product/small-size/5.jpg" alt="Li's Product Image"></a></td>
                                            <td class="li-product-name"><a href="{{ route('product', $product_cart->options->slug) }}">{{ $product_cart->name }}</a></td>
                                            <td class="li-product-price"><span class="amount">{{ $product_cart->price }} ₺</span></td>
                                            <td class="quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" value="{{ $product_cart->qty }}" type="text">
                                                    <div class="inc qtybutton product-piece-inc" data-id="{{ $product_cart->rowId }}" data-piece="{{ $product_cart->qty+1 }}">
                                                        <i class="fa fa-angle-up"></i>
                                                    </div>
                                                    <div class="dec qtybutton product-piece-dec" data-id="{{ $product_cart->rowId }}" data-piece="{{ $product_cart->qty-1 }}">
                                                        <i class="fa fa-angle-down"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><span class="amount">{{ $product_cart->subtotal }} ₺</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="coupon-all">
                                <div class="coupon">
                                    <form action="{{ route('shopping_destroy') }}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <input class="button" name="update_cart" value="Sepeti Boşalt" type="submit">
                                    </form>
                                </div>
                                <div class="coupon2">
                                    <input class="button" name="update_cart" value="Sepeti Güncelle" type="submit">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="coupon-all">
                                <div class="row justify-content-end float-right mr-0">
                                    <div class="col">
                                        <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Kupon Kodu" type="text">
                                    </div>
                                    <div class="col px-0">
                                    <input class="button" name="apply_coupon" value="Kupon Uygula" type="submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <h2>Alışveriş Toplamı</h2>
                                <ul>
                                    <li>KDV <span>{{ Cart::tax() }} ₺</span></li>
                                    <li>Tutar <span>{{ Cart::subtotal() }} ₺</span></li>
                                    <li>Toplan Tutar <span>{{ Cart::total() }} ₺</span></li>
                                </ul>
                                <a class="float-right" href="{{ route('payment') }}">Satın Al</a>
                            </div>
                        </div>
                    </div>
                @else
                    <h1>Sepetim</h1>
                    <p>Sepetinizde Ürün Bulunmamaktadır</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<script>
    $(function(){
        $('.product-piece-dec, .product-piece-inc').on('click', function(){
            let id = $(this).attr('data-id');
            let piece = $(this).attr('data-piece');
            $.ajax({
                type: 'PATCH',
                url: "{{ url('/cart/update') }}/"+id,
                data: {piece: piece},
                success: function(result){
                    window.location.href = "{{ route('shopping_cart') }}";
                }
            });
        });
    });

</script>
@endsection
