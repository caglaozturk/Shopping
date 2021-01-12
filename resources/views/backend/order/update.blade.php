@extends('backend.layouts.master')
@section('title', 'Sipariş Güncelleme')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h5 class="m-0 font-weight-bold text-primary">Sipariş {{ ($request=='show') ? 'Görüntüleme' : 'Düzenleme' }} İşlemi </h5>
				</div>
					<div class="card-body">
						@include('errors.errors')
						@include('errors.alert')
						<form action="{{ route('admin.order.save', $data->id) }}" method="POST">
							@csrf
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Adı</label>
									<input type="text" class="form-control" name="fullname" value="{{ old('fullname', $data->fullname) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Telefon</label>
									<input type="text" class="telephone form-control" name="phone_number" value="{{ old('phone_number', $data->phone_number) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Cep Telefonu</label>
									<input type="text" class="telephone form-control" name="mobile_number" value="{{ old('mobile_number', $data->mobile_number) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Adres</label>
									<textarea name="address" id="address" class="form-control" rows="10">{{ old('address', $data->address) }}</textarea>
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Durumu</label>
									<select name="status" class="form-control">
										<option value="Siparişiniz Alındı" {{ old('status', $data->status)=='Siparişiniz Alındı' ? 'selected' : '' }}>Siparişiniz Alındı</option>
										<option value="Ödeme Onaylandı" {{ old('status', $data->status)=='Ödeme Onaylandı' ? 'selected' : '' }}>Ödeme Onaylandı</option>
										<option value="Kargoya Verildi" {{ old('status', $data->status)=='Kargoya Verildi' ? 'selected' : '' }}>Kargoya Verildi</option>
										<option value="Sipariş Tamamlandı" {{ old('status', $data->status)=='Sipariş Tamamlandı' ? 'selected' : '' }}>Sipariş Tamamlandı</option>
									</select>	
								</div>
							</div>
							@if ($request != 'show')								
								<div class="form-row d-flex justify-content-center mb-3">
									<button type="submit" class="btn btn-primary justify-content-center mb-3">Kaydet</button>
								</div>
							@endif
						</form>
						<div class="row">
                            <div class="col-6">
                                <h2>Sipariş Kodu (SP-{{ $data->id }})</h2>
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
                            @foreach($data->cart->cart_products as $cartProduct)
                                <tr>
                                    <td style="width:120px">
										<a href="{{ route('product', $cartProduct->product->slug) }}">
											@php $img_url = '/frontend/images/product/large-size/'; @endphp
											{{-- <img style="width: 150px; height:100px; margin:auto; display:flex;" src="{{ (file_exists($img_url.$cartProduct->product->detail->product_image)) ? asset($img_url.$cartProduct->product->detail->product_image) : asset('uploads/empty-picture.png') }}"> --}}
											<img style="width: 150px; height:100px; margin:auto; display:flex;" src="{{ asset($img_url.$cartProduct->product->detail->product_image) }}">
										</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('product', $cartProduct->product->slug) }}">
                                            {{ $cartProduct->product->product_name }}
                                        </a>
                                    </td>
                                    <td>{{ $cartProduct->price }} ₺</td>
                                    <td>{{ $cartProduct->piece }}</td>
                                    <td>{{ $cartProduct->price * $cartProduct->piece }} ₺</td>
                                    <td>{{ $cartProduct->status }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="4" class="text-right">Toplam Tutar</th>
                                <td colspan="2">{{ $data->siparis_tutari }} ₺</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Toplam Tutar (KDV'li)</th>
                                <td colspan="2">{{ $data->siparis_tutari* ((100+config('cart.tax'))/100) }} ₺</td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">Sipariş Durumu</th>
                                <td colspan="2">{{ $data->status }}</td>
                            </tr>
                        </table>
					</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.15.1/plugins/autogrow/plugin.min.js"></script>
	<script>
		var options = {
			uiColor: '#4e73df',
			extraPlugins: 'autogrow',
			//autoGrow_minHeight: 300,
			autoGrow_maxHeight: 600
		}
		CKEDITOR.replace('address', options);
	</script>
@endsection