@extends('backend.layouts.master')
@section('title', 'Ürün')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h5 class="m-0 font-weight-bold text-primary">Ürün {{ $data->id>0 ? ($request=='show') ? 'Görüntüleme' : 'Düzenleme' : 'Ekleme' }} İşlemi </h5>
				</div>
					<div class="card-body">
						@include('errors.errors')
						@include('errors.alert')
						<form action="{{ route('admin.product.save', $data->id) }}" enctype="multipart/form-data" method="POST" >
							@csrf
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Adı</label>
									<input type="text" class="form-control" name="product_name" value="{{ old('product_name', $data->product_name) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Slug</label>
									<input type="hidden" name="original_slug" value="{{ old('slug', $data->slug) }}">
									<input type="text" class="form-control" name="slug" value="{{ old('slug', $data->slug) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Fiyatı</label>
									<input type="number" class="form-control" name="price" value="{{ old('price', $data->price) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Description</label>
									<textarea name="description" id="description" class="form-control" rows="10">{{ old('description', $data->description) }}</textarea>
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<input type="hidden" name="show_slider" value="0">
									<input type="checkbox" name="show_slider" value="1" {{ old('show_slider', $data->detail->show_slider) ? 'checked' : '' }}>Slider
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<input type="hidden" name="show_today_chance" value="0">
									<input type="checkbox" name="show_today_chance" value="1" {{ old('show_today_chance', $data->detail->show_today_chance) ? 'checked' : '' }}>Günlük
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<input type="hidden" name="show_featured" value="0">
									<input type="checkbox" name="show_featured" value="1" {{ old('show_featured', $data->detail->show_featured) ? 'checked' : '' }}>Öne Çıkan
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<input type="hidden" name="show_bestseller" value="0">
									<input type="checkbox" name="show_bestseller" value="1" {{ old('show_bestseller', $data->detail->show_bestseller) ? 'checked' : '' }}>Çok Satan
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<input type="hidden" name="show_discount" value="0">
									<input type="checkbox" name="show_discount" value="1" {{ old('show_discount', $data->detail->show_discount) ? 'checked' : '' }}>İndirimli
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Kategoriler</label>
									<select name="categories[]" multiple id="categories" class="form-control">
										@foreach ($all_categories as $category)
											<option value="{{ $category->id }}" {{ collect(old('categories', $product_category))->contains($category->id) ? 'selected' : '' }}>{{ $category->category_name }}</option>
										@endforeach
									</select>	
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									@if ($data->detail->product_image != null)
										<img class="thumbnail pull-left" src="/uploads/products/{{ $data->detail->product_image }}" style="height:100px; margin-bottom:20px;display:block;">
									@endif
									<label>Resim</label>
									<input type="file" class="form-control" name="product_file">
								</div>
							</div>
							@if ($request != 'show')								
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
@section('head')	
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('footer')
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

	<script>
		$(function(){
			$('#categories').select2({
				placeholder: 'Lütfen Kategori Seçiniz'
			});			
		});
		var options = {
			uiColor: '#4e73df',
			extraPlugins: 'autogrow',
			//autoGrow_minHeight: 300,
			autoGrow_maxHeight: 600
		}
		CKEDITOR.replace('description', options);
	</script>
@endsection