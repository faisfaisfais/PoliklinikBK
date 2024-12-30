@extends('layouts.admin')

@section('title')
    Data Obat
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Obat</h2>
                <p class="dashboard-subtitle">
                    Daftar Obat
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('obat.create') }}" class="btn btn-primary mb-3">
                                    + Tambah Obat Baru
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama Obat</th>
                                                <th>Kemasan</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($listObat as $obat)
                                                <tr>
                                                    <td>{{ $obat->id }}</td>
                                                    <td>{{ $obat->namaObat }}</td>
                                                    <td>{{ $obat->kemasan }}</td>
                                                    <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                                    <td>
                                                        <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-info">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <form action="{{ route('obat.destroy', $obat->id) }}" method="POST"
                                                            class="d-inline">
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
