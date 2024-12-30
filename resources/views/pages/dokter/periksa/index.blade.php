@extends('layouts.dokter')

@section('title')
    Data Periksa Pasien
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Periksa Pasien</h2>
                <p class="dashboard-subtitle">
                    Daftar Pasien Diperiksa
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
                                                <th>No Urut</th>
                                                <th>Nama Pasien</th>
                                                <th>Keluhan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($periksaPasien as $pasien)
                                                <tr>
                                                    <td>{{ $pasien->antrian }}</td>
                                                    <td>{{ $pasien->pasien->namaPasien }}</td>
                                                    <td>{{ $pasien->keluhan }}</td>
                                                    <td>
                                                        @php
                                                            $hasChecked = $pasien->poli_periksa()->first(); 
                                                        @endphp

                                                        @if ($hasChecked)
                                                            <!-- Jika pasien sudah diperiksa, tampilkan tombol edit -->
                                                            <a href="{{ route('periksa.edit', ['id' => $hasChecked->id]) }}"
                                                                class="btn btn-warning">
                                                                <i class="fa fa-pencil-alt"> Edit</i>
                                                            </a>
                                                        @else
                                                            <!-- Jika pasien belum diperiksa, tampilkan tombol periksa -->
                                                            <a href="{{ route('periksa.create', ['id' => $pasien->id]) }}"
                                                                class="btn btn-info">
                                                                <i class="fas fa-stethoscope"> Periksa</i>
                                                            </a>
                                                        @endif
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
