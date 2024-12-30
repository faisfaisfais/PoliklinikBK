@extends('layouts.admin')

@section('title')
    Poli Poliklinik
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Poli</h2>
                <p class="dashboard-subtitle">
                    Daftar Poli
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('poli.create') }}" class="btn btn-primary mb-3">
                                    + Tambah Poli
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Poli</th>
                                                <th>Deskripsi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($listPoli as $poli)
                                                <tr>
                                                    <td>{{ $poli->id }}</td>
                                                    <td>{{ $poli->namaPoli }}</td>
                                                    <td>{{ $poli->deskripsi }}</td>
                                                    <td>
                                                        <a href="{{ route('poli.edit', $poli->id) }}"
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