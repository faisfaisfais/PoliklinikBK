@extends('layouts.admin')

@section('title')
    Data Pasien
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Pasien</h2>
                <p class="dashboard-subtitle">
                    Daftar Pasien
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3">
                                    + Pasien Baru
                                </a>
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
                                                        <a href="{{ route('pasien.edit', $pasien->id) }}"
                                                            class="btn btn-info">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <form action="{{ route('pasien.destroy', $pasien->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
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
