@extends('layouts.admin')

@section('title')
  Tambah Obat
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
        <h2 class="dashboard-title">Obat</h2>
        <p class="dashboard-subtitle">
            Tambah Obat Baru
        </p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-12">
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <form action="{{ route('obat.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="namaObat">Nama Obat</label>
                        <input type="text" class="form-control" name="namaObat" placeholder="Nama Obat"
                            value="{{ old('namaObat') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="kemasan">Kemasan</label>
                        <input type="text" class="form-control" name="kemasan" placeholder="Kemasan"
                            value="{{ old('kemasan') }}">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" name="harga" placeholder="Harga"
                            value="{{ old('harga') }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col text-right">
                    <button
                      type="submit"
                      class="btn btn-success px-5"
                    >
                      Save Now
                    </button>
                  </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('addon-script')
  <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
  <script>
    CKEDITOR.replace('editor');
  </script>
@endpush