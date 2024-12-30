@extends('layouts.pasien')

@section('title')
    Detail Pemeriksaan Pasien
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Detail Pemeriksaan</h2>
                <p class="dashboard-subtitle">
                    Detail Pemeriksaan Pasien
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <tr>
                                            <th>Nama Poli</th>
                                            <td>{{ $pasien_periksa->jadwal_appointment->jadwal_dokter->poli->namaPoli }}
                                        </tr>
                                        <tr>
                                            <th>Nama Dokter</th>
                                            <td>{{ $pasien_periksa->jadwal_appointment->jadwal_dokter->namaDokter }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Hari Booking</th>
                                            <td>{{ $pasien_periksa->jadwal_appointment->hari }}</td>
                                        </tr>
                                        <tr>
                                            <th>Waktu Mulai</th>
                                            <td>{{ $pasien_periksa->jadwal_appointment->jamMulai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Waktu Selesai</th>
                                            <td>{{ $pasien_periksa->jadwal_appointment->jamSelesai }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Antrian</th>
                                            <td class="queue-number-text">{{ $pasien_periksa->antrian }}</td>
                                        </tr>
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

@stack('addon-style')
<style>
    .queue-number-text, .price-text {
        font-size: 1.5em;
        /* Perbesar ukuran teks */
        font-weight: bold;
        /* Buat teks lebih tebal */
        color: #343a40;
        /* Warna teks gelap (default Bootstrap) */
    }
</style>