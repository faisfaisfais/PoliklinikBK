@extends('layouts.dokter')

@section('title')
    Jadwal Dokter
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Jadwal Dokter</h2>
                <p class="dashboard-subtitle">
                    Daftar Jadwal Dokter
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">
                                    + Tambah Jadwal Baru
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Dokter</th>
                                                <th>Hari</th>
                                                <th>Jam Mulai</th>
                                                <th>Jam Selesai</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($listJadwal as $jadwal)
                                                <tr>
                                                    <td>{{ $jadwal->id }}</td>
                                                    <td>{{ $jadwal->jadwal_dokter->namaDokter }}</td>
                                                    <td>{{ $jadwal->hari }}</td>
                                                    <td>{{ $jadwal->jamMulai }}</td>
                                                    <td>{{ $jadwal->jamSelesai }}</td>
                                                    <td>{{ $jadwal->status }}</td>
                                                    <td>
                                                        <a href="{{ route('jadwal.edit', $jadwal->id) }}"
                                                            class="btn btn-info">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
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
