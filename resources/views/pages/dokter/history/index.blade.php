@extends('layouts.dokter')

@section('title')
    History Pasien
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">History Pasien</h2>
                <p class="dashboard-subtitle">
                    Daftar History Pemeriksaan Pasien
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIK</th>
                                                <th>Nama Pasien</th>
                                                <th>Alamat</th>
                                                <th>No HP</th>
                                                <th>No RM</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($listPasien as $pasien)
                                                <tr>
                                                    <td>{{ $pasien->id }}</td>
                                                    <td>{{ $pasien->nik }}</td>
                                                    <td>{{ $pasien->namaPasien }}</td>
                                                    <td>{{ $pasien->alamat }}</td>
                                                    <td>{{ $pasien->noHP }}</td>
                                                    <td>{{ $pasien->nomorRM }}</td>
                                                    <td>
                                                        @foreach ($pasien->pasien_poli as $pasien_poli)
                                                            @if ($pasien_poli->sudahPeriksa())
                                                                <a href="{{ route('history.show', $pasien->id) }}"
                                                                    class="btn btn-primary">
                                                                    <i class="fa fa-eye"> Detail Periksa</i>
                                                                </a>
                                                            @else
                                                                <span class="text-danger">Belum Diperiksa</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Data Kosong</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection