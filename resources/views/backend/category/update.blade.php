@extends('backend.layouts.master')
@section('title', 'Category Güncelleme')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h5 class="m-0 font-weight-bold text-primary">Kategori {{ $data->id>0 ? ($request=='show') ? 'Görüntüleme' : 'Düzenleme' : 'Ekleme' }} İşlemi </h5>
				</div>
					<div class="card-body">
						@include('errors.errors')
						@include('errors.alert')
						<form action="{{ route('admin.category.save', $data->id) }}" method="POST">
							@csrf
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Üst Kategori</label>
									<select name="parent_id" class="form-control">
										<option value="" {{ ($data->parent_id=='') ? 'selected' : '' }}>Ana Kategori</option>
										@foreach ($all_categories as $category)											
											<option value="{{ $category->id }}" {{ ($category->id==$data->parent_id) ? 'selected' : '' }}  >{{ $category->category_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Adı</label>
									<input type="text" class="form-control" name="category_name" value="{{ old('category_name', $data->category_name) }}">
								</div>
							</div>
							<div class="form-row d-flex justify-content-center mb-3">
								<div class="form-group col-md-6">
									<label>Slug</label>
									<input type="hidden" name="original_slug" value="{{ old('slug', $data->slug) }}">
									<input type="text" class="form-control" name="slug" value="{{ old('slug', $data->slug) }}">
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