@extends('layouts.dokter')

@section('title')
    Periksa Pasien
@endsection

@section('content')
    <!-- Section Content -->
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Periksa Pasien</h2>
                <p class="dashboard-subtitle">
                    Silahkan Lakukan Pemeriksaan Pasien "{{ $periksaPasien->pasien->namaPasien }}"
                </p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('periksa.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="daftar_poli_id" value="{{ $periksaPasien->id }}">
                                        <!-- Menambahkan hidden field -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="namaPsien">No RM</label>
                                                <input type="text" class="form-control" name="namaPsien"
                                                    id="namaPsien" value="{{ $periksaPasien->pasien->nomorRM }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tanggalPeriksa">Tanggal Pemeriksaan</label>
                                                <input type="datetime-local" class="form-control" name="tanggalPeriksa"
                                                    id="tanggalPeriksa"
                                                    value="{{ old('tanggalPeriksa', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="catatan">Catatan</label>
                                                <textarea name="catatan" rows="5" class="d-block w-100 form-control">{{ old('catatan') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <!-- Obat yang dipilih -->
                                            <div class="form-group position-relative">
                                                <label for="cari-obat">Cari Obat</label>
                                                <input type="text" id="cari-obat" class="form-control"
                                                    placeholder="Ketik nama atau kemasan obat...">
                                                <div id="obat-dropdown" class="dropdown-menu" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="obat-dipilih" class="mt-3">
                                                <!-- Obat yang dipilih akan ditampilkan di sini -->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="harga">Harga Total</label>
                                                <input type="text" id="harga" name="harga" class="form-control"
                                                    readonly value="150000">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('cari-obat');
                const dropdown = document.getElementById('obat-dropdown');
                const selectedObatContainer = document.getElementById('obat-dipilih');
                const priceInput = document.getElementById('harga');
                let totalHarga = 150000; // Harga dasar

                // Mencari obat saat mengetik
                searchInput.addEventListener('input', function() {
                    const query = this.value;

                    if (query.length > 2) {
                        fetch(`{{ route('obat.search') }}?query=${query}`)
                            .then(response => response.json())
                            .then(listObat => {
                                dropdown.innerHTML = '';
                                dropdown.style.display = 'block';

                                listObat.forEach(obat => {
                                    const item = document.createElement('a');
                                    item.classList.add('dropdown-item');
                                    item.textContent =
                                        `${obat.namaObat} | ${obat.kemasan} | Rp. ${obat.harga.toLocaleString()}`;
                                    item.setAttribute('data-id', obat.id);
                                    item.setAttribute('data-name', obat.namaObat);
                                    item.setAttribute('data-price', obat.harga);
                                    item.addEventListener('click', addObat);
                                    dropdown.appendChild(item);
                                });
                            });
                    } else {
                        dropdown.style.display = 'none';
                    }
                });

                // Menambahkan obat ke daftar
                function addObat(event) {
                    event.preventDefault();
                    const obatId = this.getAttribute('data-id');
                    const namaObat = this.getAttribute('data-name');
                    const harga = parseInt(this.getAttribute('data-price'));
                    const kemasan = this.textContent.split('|')[1].trim();

                    const listItem = document.createElement('div');
                    listItem.classList.add('obat-item');
                    listItem.innerHTML = `<span>${namaObat} | ${kemasan} | Rp. ${harga.toLocaleString()}</span>
                        <button type="button" class="btn btn-danger btn-sm ml-2 remove-obat" data-price="${harga}">Hapus</button>
                        <input type="hidden" name="listObat[]" value="${obatId}">`;
                    listItem.querySelector('.remove-obat').addEventListener('click', removeObat);

                    selectedObatContainer.appendChild(listItem);
                    dropdown.style.display = 'none';

                    totalHarga += harga;
                    updateTotalHarga();
                }

                // Menghapus obat dari daftar
                function removeObat() {
                    const harga = parseInt(this.getAttribute('data-price'));
                    this.parentElement.remove();

                    totalHarga -= harga;
                    updateTotalHarga();
                }

                // Memperbarui total harga
                function updateTotalHarga() {
                    priceInput.value = totalHarga.toLocaleString();
                }
            });
        </script>
    </div>
@endsection
