@extends('backend.layouts.master')
@section('title', 'Ürün Listesi')
@section('content')
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col d-flex">
                    <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">Kullanıcı Listesi</h6>
                </div>
                <div class="col d-flex justify-content-end">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Yeni</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('errors.alert')
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Email</th>
                            <th>Aktif Mi</th>
                            <th>Yönetici Mi</th>
                            <th>Kayıt Tarihi</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Email</th>
                            <th>Aktif Mi</th>
                            <th>Yönetici Mi</th>
                            <th>Kayıt Tarihi</th>
                            <th>İşlem</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if (count($lists) == 0)
                            <tr><td colspan="6" class="text-center">Kayıt Bulunamadı!</td></tr>
                        @endif
                        @foreach ($lists as $list)
                            <tr>
                                <td>{{ $list->fullname }}</td>
                                <td>{{ $list->email }}</td>
                                <td>
                                    @if ($list->is_active)
                                        <div class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Aktif</span>
                                        </div>
                                    @else
                                        <div class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">Pasif</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($list->is_admin)
                                        <div class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Yönetici</span>
                                        </div>
                                    @else
                                        <div class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">Müşteri</span>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $list->created_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.user.update', ['update',$list->id]) }}" class="btn btn-success btn-sm btn-icon-split">
                                            <span class="icon text-white-60">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>
                                        <a href="{{ route('admin.user.delete', $list->id) }}" onclick="return confirm('Emin Misiniz?')" class="btn btn-danger btn-sm btn-icon-split mx-1">
                                          <span class="icon text-white-60">
                                            <i class="fas fa-trash"></i>
                                          </span>
                                        </a>
                                        <a href="{{ route('admin.user.update', ['show',$list->id,]) }}" class="btn btn-primary btn-sm btn-icon-split">
                                            <span class="icon text-white-60">
                                            <i class="fas fa-eye"></i>
                                            </span>
                                        </a>
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- {{ $lists->appends('aranan', old('aranan'))->links() }} --}}
        </div>
    </div>

</div>
@endsection