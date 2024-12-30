@extends('layouts.dokter')

@section('title')
  Edit Jadwal Dokter
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
        <h2 class="dashboard-title">Jadwal Dokter</h2>
        <p class="dashboard-subtitle">
            Edit Jadwal "{{ $listJadwal->jadwal_dokter->namaDokter }}"
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
          <form action="{{ route('jadwal.update', $listJadwal->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="hari">Hari Jadwal</label>
                        <select class="form-control" name="hari">
                            <option value="Senin"
                                {{ old('hari', $listJadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin
                            </option>
                            <option value="Selasa"
                                {{ old('hari', $listJadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa
                            </option>
                            <option value="Rabu"
                                {{ old('hari', $listJadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu
                            </option>
                            <option value="Kamis"
                                {{ old('hari', $listJadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis
                            </option>
                            <option value="Jumat"
                                {{ old('hari', $listJadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat
                            </option>
                            <option value="Sabtu"
                                {{ old('hari', $listJadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu
                            </option>
                            <option value="Minggu"
                                {{ old('hari', $listJadwal->hari) == 'Minggu' ? 'selected' : '' }}>Minggu
                            </option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="jamMulai">Waktu Mulai</label>
                        <input type="time" class="form-control" name="jamMulai"
                            value="{{ $listJadwal->jamMulai }}">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="jamSelesai">Waktu Selesai</label>
                        <input type="time" class="form-control" name="jamSelesai"
                            value="{{ $listJadwal->jamSelesai }}">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="Aktif" @if ($listJadwal->status == 'Aktif') selected @endif>Aktif</option>
                            <option value="Tidak Aktif" @if ($listJadwal->status == 'Tidak Aktif') selected @endif>Tidak Aktif</option>
                        </select>
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