@extends('layouts.pasien')

@section('title')
    Buat Pemeriksaan
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Booking Pemeriksaan</h2>
                <p class="dashboard-subtitle">
                    Tambah data booking pemeriksaan
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
                        <form action="{{ route('pasien_periksa.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nomorRM">No RM Pasien</label>
                                                <input type="text" class="form-control" name="nomorRM"
                                                    value="{{ Auth::guard('pasien')->user()->nomorRM }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="poli_id">Poli</label>
                                                <select class="form-control" id="poli_id" name="poli_id">
                                                    <option value="" disabled selected>Pilih Poli</option>
                                                    @foreach ($listPoli as $poli)
                                                        <option value="{{ $poli->id }}">{{ $poli->namaPoli }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="jadwal_periksa_id">Jadwal</label>
                                                <select class="form-control" id="jadwal_periksa_id" name="jadwal_periksa_id"
                                                    disabled>
                                                    <option value="" disabled selected>Pilih Jadwal</option>
                                                    {{-- Jadwal akan diisi melalui JavaScript --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="keluhan">Keluhan</label>
                                                <textarea name="keluhan" rows="5" class="d-block w-100 form-control">{{ old('keluhan') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
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

    <script>
        document.getElementById('poli_id').addEventListener('change', function() {
            const poliId = this.value;
            const jadwalDropdown = document.getElementById('jadwal_periksa_id');

            jadwalDropdown.innerHTML = '<option value="" disabled selected>Memuat jadwal...</option>';
            jadwalDropdown.disabled = true;

            fetch(`/api/jadwal/${poliId}`)
                .then(response => response.json())
                .then(data => {
                    jadwalDropdown.innerHTML = '<option value="" disabled selected>Pilih Jadwal</option>';
                    data.forEach(jadwal => {
                        const optionText =
                            `${jadwal.dokter} | ${jadwal.hari} | ${jadwal.jamMulai} - ${jadwal.jamSelesai}`;
                        jadwalDropdown.innerHTML +=
                            `<option value="${jadwal.id}">${optionText}</option>`;
                    });
                    jadwalDropdown.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    jadwalDropdown.innerHTML =
                        '<option value="" disabled selected>Error memuat jadwal</option>';
                });
        });
    </script>
@endpush
