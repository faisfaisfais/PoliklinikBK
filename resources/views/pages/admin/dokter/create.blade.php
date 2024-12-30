@extends('layouts.admin')

@section('title')
  Buat Dokter
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
        <h2 class="dashboard-title">Dokter</h2>
        <p class="dashboard-subtitle">
            Buat dokter baru
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
          <form action="{{ route('dokter.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username"
                            value="{{ old('username') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password"
                            value="{{ old('password') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="poli_id">Nama Poli</label>
                        <select name="poli_id" required class="form-control">
                            <option value="">Pilih Poli</option>
                            @foreach ($listPoli as $poli )
                                <option value="{{ $poli->id }}">
                                    {{ $poli->namaPoli }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="namaDokter">Nama Dokter</label>
                        <input type="text" class="form-control" name="namaDokter" placeholder="Nama Dokter"
                            value="{{ old('namaDokter') }}"> {{-- fungsi old berfungsi ketika user mungkin salah input data dan ternyata input error maka data tidak akan hilang --}}
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
                        <label for="noHP">No HP</label>
                        <input type="text" class="form-control" name="noHP" placeholder="No HP"
                            value="{{ old('noHP') }}">
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