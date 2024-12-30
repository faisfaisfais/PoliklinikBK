@extends('layouts.admin')

@section('title')
  Buat Poli
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
        <h2 class="dashboard-title">Poli</h2>
        <p class="dashboard-subtitle">
            Buat poli baru
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
          <form action="{{ route('poli.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="namaPoli">Nama Poli</label>
                        <input type="text" class="form-control" name="namaPoli" placeholder="Nama Poli"
                            value="{{ old('namaPoli') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="deskripsi">Keterangan</label>
                        <input type="text" class="form-control" name="deskripsi" placeholder="Keterangan"
                            value="{{ old('deskripsi') }}">
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