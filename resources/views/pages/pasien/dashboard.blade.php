@extends('layouts.pasien')

@section('title')
    Pasien Dashboard
@endsection

@section('content')
<!-- Section Content -->
<div
    class="section-content section-dashboard-home"
    data-aos="fade-up"
    >
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Dashboard Pasien</h2>
            <p class="dashboard-subtitle">
                Ini adalah dashboard poliklinik untuk pasien
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="dashboard-card-title">
                                Pemeriksaan
                            </div>
                            <div class="dashboard-card-subtitle">
                                {{ $pasien_periksa }}
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection