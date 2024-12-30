@extends('layouts.admin')

@section('title')
  Tambah Pasien
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
        <h2 class="dashboard-title">Pasien</h2>
        <p class="dashboard-subtitle">
            Tambah Pasien Baru
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
          <form action="{{ route('pasien.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="nik">NIK Pasien</label>
                        <input type="text" class="form-control" name="nik" placeholder="NIK Pasien"
                            value="{{ old('nik') }}">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="namaPasien">Nama Pasien</label>
                        <input type="text" class="form-control" name="namaPasien" placeholder="Nama Pasien"
                            value="{{ old('namaPasien') }}">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" rows="5" class="d-block w-100 form-control">{{ old('alamat') }}</textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="noHP">No Telepon</label>
                        <input type="text" class="form-control" name="noHP" placeholder="No Telepon"
                            value="{{ old('noHP') }}">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="nomorRM">No RM</label>
                        <input type="text" class="form-control" name="nomorRM" placeholder="No RM"
                            value="{{ old('nomorRM', $nomorRMBaru) }}" readonly> {{-- Menampilkan No RM otomatis --}}
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