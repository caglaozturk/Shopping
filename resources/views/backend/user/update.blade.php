@extends('backend.layouts.master')
@section('title', 'Ana Sayfa')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h5 class="m-0 font-weight-bold text-primary">Kullanıcı Düzenleme İşlemi </h5>
				</div>
					<div class="card-body">
						@include('errors.errors')
						@include('errors.alert')
						<form action="{{ route('admin.user.save', $data->id) }}" method="POST">
							@csrf
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>İsim Soyisim</label>
									<input type="text" class="form-control" name="fullname" value="{{ old('fullname', $data->fullname) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Şifre</label>
									<input type="password" class="form-control" name="password" placeholder="Şifre Giriniz">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>E-Posta</label>
									<input type="email" class="form-control"  name="email" value="{{ old('email', $data->email) }}">
								</div>	
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Telefon</label>
									<input type="text" class="form-control telephone" name="phone_number" value="{{ old('phone_number', $data->detail->phone_number) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Cep Telefonu</label>
									<input type="text" class="form-control telephone" name="mobile_number" value="{{ old('mobile_number', $data->detail->mobile_number) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<input type="hidden" name="is_active" value="0">
									<input type="checkbox" name="is_active" value="1" {{ old('is_active', $data->is_active) ? 'checked' : '' }}>Aktif Mi
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<input type="hidden" name="is_admin" value="0">
									<input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $data->is_admin) ? 'checked' : '' }}>Yönetici Mi
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<textarea class="form-control" rows="10" name="address">{{ old('address', $data->detail->address) }}</textarea>
								</div>
							</div>
							@if ($request == 'update')								
								<div class="form-row d-flex justify-content-center mb-3">
									<button type="submit" class="btn btn-primary justify-content-center mb-3">Kaydet</button>
								</div>
							@endif
						</form>
					</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer')    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script>
		$('.telephone').mask('(000) 000-00-00', { placeholder: "(___) ___-__-__" });
    </script>
@endsection