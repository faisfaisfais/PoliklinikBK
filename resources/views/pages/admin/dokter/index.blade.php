@extends('layouts.admin')

@section('title')
    Data Dokter
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Dokter</h2>
                <p class="dashboard-subtitle">
                    Daftar Dokter
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('dokter.create') }}" class="btn btn-primary mb-3">
                                    + Tambah Dokter Baru
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Dokter</th>
                                                <th>Alamat</th>
                                                <th>No HP</th>
                                                <th>Poli</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($listDokter as $dokter)
                                                <tr>
                                                    <td>{{ $dokter->id }}</td>
                                                    <td>{{ $dokter->namaDokter }}</td>
                                                    <td>{{ $dokter->alamat }}</td>
                                                    <td>{{ $dokter->noHP }}</td>
                                                    <td>{{ $dokter->poli->namaPoli }}</td>
                                                    <td>
                                                        <a href="{{ route('dokter.edit', $dokter->id) }}"
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
