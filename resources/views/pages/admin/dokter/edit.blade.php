@extends('layouts.admin')

@section('title')
  Edit Dokter
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
            Edit "{{ $listDokter->namaDokter }}"
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
          <form action="{{ route('dokter.update', $listDokter->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="poli_id">Nama Poli</label>
                        <select name="poli_id" required class="form-control">
                            <option value="{{ $listDokter->poli_id }}">Jangan Diubah</option>
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
                            value="{{ $listDokter->namaDokter }}">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" placeholder="Alamat" rows="5">{{ $listDokter->alamat }}
                                </textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="noHP">No HP</label>
                        <input type="text" class="form-control" name="noHP" placeholder="No HP"
                            value="{{ $listDokter->noHP }}">
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