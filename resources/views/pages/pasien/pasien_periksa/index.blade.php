@extends('layouts.pasien')

@section('title')
    Store Dashboard
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Pemeriksaan</h2>
                <p class="dashboard-subtitle">
                    Daftar pemeriksaan yang telah dilakukan
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('pasien_periksa.create') }}" class="btn btn-primary mb-3">
                                    + Booking Pemeriksaan
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Poli</th>
                                                <th>Dokter</th>
                                                <th>Hari</th>
                                                <th>Mulai</th>
                                                <th>Selesai</th>
                                                <th>Antrian</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp

                                            @forelse ($pasien_periksa as $periksa)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $periksa->jadwal_appointment->jadwal_dokter->poli->namaPoli }}
                                                    </td>
                                                    <td>{{ $periksa->jadwal_appointment->jadwal_dokter->namaDokter }}
                                                    </td>
                                                    <td>{{ $periksa->jadwal_appointment->hari }}
                                                    </td>
                                                    <td>{{ $periksa->jadwal_appointment->jamMulai }}
                                                    </td>
                                                    <td>{{ $periksa->jadwal_appointment->jamSelesai }}
                                                    </td>
                                                    <td>{{ $periksa->antrian }}</td>
                                                    <td>
                                                        @if ($periksa->sudahPeriksa())
                                                            <span class="badge badge-success">Sudah Periksa</span>
                                                        @else
                                                            <span class="badge badge-danger">Belum Periksa</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('pasien_periksa.show', $periksa->id) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Data Kosong</td>
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
