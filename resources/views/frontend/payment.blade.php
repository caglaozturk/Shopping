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
                        <form action="{{ route('pay') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <h3>Ödeme Bilgileri</h3>
                                    <div class="form-group">
                                        <label for="kart_numarasi">Kredi Kartı Numarası</label>
                                        <input type="text" class="form-control kredikarti" id="kart_numarasi" name="credit_card" style="font-size:20px;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="son_kullanma_tarihi_ay">Son Kullanma Tarihi</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                Ay
                                                <select name="expiration_date_month" id="son_kullanma_tarihi_ay" class="form-control" required>
                                                    <?php for( $m=1; $m<=12; ++$m ) { 
                                                      $month_label = date('F', mktime(0, 0, 0, $m, 1));
                                                    ?>
                                                      <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
                                                    <?php } ?>
                                                </select> 
                                            </div>
                                            <div class="col-md-6">
                                                Yıl
                                                <select id="son_kullanma_tarihi_yil" name="expiration_date_year" class="form-control" required>
                                                    <?php 
                                                      $year = date('Y');
                                                      $min = $year - 60;
                                                      $max = $year;
                                                      for( $i=$max; $i>=$min; $i-- ) {
                                                        echo '<option value='.$i.'>'.$i.'</option>';
                                                      }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="card_cvv">CVV (Güvenlik Numarası)</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control kredikarti_cvv" name="card_cvv" id="card_cvv" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout-form-list create-acc">
                                        <input id="cbox" type="checkbox" checked>
                                        <label>Ön bilgilendirme formunu okudum ve kabul ediyorum.</label>
                                    </div>
                                    <div class="checkout-form-list create-acc">
                                        <input id="cbox" type="checkbox" checked>
                                        <label>Mesafeli satış sözleşmesini okudum ve kabul ediyorum.</label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <h3>İletişim ve Fatura Bilgileri</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="adsoyad">Ad Soyad</label>
                                                <input type="text" class="form-control" name="fullname" id="adsoyad" value="{{ auth()->user()->fullname }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="adres">Adres</label>
                                                <input type="text" class="form-control" name="address" id="adres" value="{{ $user_detail->address }}" required>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="telefon">Telefon</label>
                                                <input type="text" class="form-control telefon" name="phone_number" id="telefon" value="{{ $user_detail->phone_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="ceptelefonu">Cep Telefonu</label>
                                                <input type="text" class="form-control telefon" name="mobile_number" id="ceptelefonu" value="{{ $user_detail->mobile_number }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <h4>Ödenecek Tutar : <i>{{ Cart::total() }} TL</i></h4>
                                </div>
                            </div>
                            <div class="payment-method mt-0">
                                <div class="payment-accordion">
                                    <div class="order-button-payment">
                                        <input value="Ödeme Yap" type="submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script>
        $('.kredikarti').mask('0000-0000-0000-0000', { placeholder: "____-____-____-____" });
        $('.kredikarti_cvv').mask('000', { placeholder: "___" });
        $('.telefon').mask('(000) 000-00-00', { placeholder: "(___) ___-__-__" });
    </script>
@endsection