@extends('layouts.dokter')

@section('title')
    Detail History Pasien
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Detail History Pasien</h2>
                <p class="dashboard-subtitle">
                    Detail History Pemeriksaan Pasien {{ $pasien->namaPasien }}
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
                                                <th>Tanggal Periksa</th>
                                                <th>Nama Pasien</th>
                                                <th>Nama Dokter</th>
                                                <th>Keluhan</th>
                                                <th>Catatan</th>
                                                <th>Obat</th>
                                                <th>Biaya Periksa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1; // Variabel penghitung untuk nomor urut
                                            @endphp

                                            @foreach ($pasien->pasien_poli as $poli)
                                                @foreach ($poli->poli_periksa as $periksa)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $periksa->tanggalPeriksa }}</td>
                                                        <td>{{ $pasien->namaPasien }}</td>
                                                        <td>{{ $periksa->daftar_poli->jadwal_appointment->jadwal_dokter->namaDokter }}
                                                        </td>
                                                        <td>{{ $poli->keluhan }}</td>
                                                        <td>{{ $periksa->catatan }}</td>
                                                        <td>
                                                            @if ($periksa->periksa_obat->isEmpty())
                                                                Tidak ada obat
                                                            @else
                                                                <ul>
                                                                    @foreach ($periksa->periksa_obat as $obat)
                                                                        <li>{{ $obat->namaObat }}
                                                                            ({{ $obat->kemasan }})</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($periksa->harga, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
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
