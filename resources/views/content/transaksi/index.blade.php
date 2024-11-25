@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Transaksi')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Data Transaksi</span>
</h4>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="tambahModalLabel">Tambah Transaksi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="mb-3">
                <label for="pasien_id" class="form-label">Pasien</label> <!-- Ubah id_pasien menjadi pasien_id -->
                <select name="pasien_id" class="form-select" required> <!-- Pastikan nama input adalah pasien_id -->
                    <option value="">Pilih Pasien</option>
                    @foreach ($pasien as $pasien)
                        <option value="{{ $pasien->id_pasien }}">{{ $pasien->nama }}</option> <!-- id_pasien sesuai dengan database -->
                    @endforeach
                </select>
            </div>

            <div class="form-group">
              <label for="obat_id">Pilih Obat</label>
              <select name="obat_id" id="obat_id" class="form-control" required>
                  <option value="">Pilih Obat</option>
                  @php
                      // Ambil semua stok sekaligus
                      $stoks = App\Models\Stok::whereIn('obat_id', $obats->pluck('id'))->get()->keyBy('obat_id');
                  @endphp
                  @foreach($obats as $obat)
                      @php
                          // Ambil jumlah stok untuk obat ini
                          $jumlah_stok = $stoks->has($obat->id) ? $stoks[$obat->id]->jumlah_stok : 0;
                      @endphp
                      <option value="{{ $obat->id }}">
                          {{ $obat->nama_obat }} - Stok: {{ $jumlah_stok }}
                      </option>
                  @endforeach
              </select>
          </div>

            <div class="mb-3">
                <label for="jumlah_obat" class="form-label">Jumlah Obat</label>
                <input type="number" name="jumlah_obat" class="form-control" required min="1"> <!-- Pastikan ini adalah angka positif -->
            </div>

            <div class="mb-3">
                <label for="status_transaksi" class="form-label">Status Transaksi</label>
                <select name="status_transaksi" class="form-select" required> <!-- Nama input sudah benar -->
                    <option value="">Pilih Status Transaksi</option> <!-- Tambahkan opsi default -->
                    <option value="pending">Pending</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
        </div>
    </form>
    </div>
  </div>
</div>

<!-- Tombol untuk memunculkan modal tambah -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
  Tambah Transaksi
</button>

<div class="card mt-3">
  <h5 class="card-header">Tabel Transaksi</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-borderless">
      <thead>
        <tr>
          <th>Pegawai</th>
          <th>Level</th>
          <th>Pasien</th>
          <th>Obat</th>
          <th>Jumlah Obat</th>
          <th>Harga Total</th>
          <th>Tanggal</th>
          <th>Status Transaksi</th>
          @if(auth()->user()->level === 'admin')
          <th>Aksi</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($transaksi as $transaksi)
        <tr>
          <td>{{ $transaksi->user->nama }}</td>
          <td>{{ $transaksi->user->level }}</td>
          <td>{{ $transaksi->pasien->nama }}</td>
          <td>{{ $transaksi->obat->nama_obat }}</td>
          <td>{{ $transaksi->jumlah_obat }}</td>
          <td>{{ $transaksi->harga_total }}</td>
          <td>{{ $transaksi->tanggal }}</td>
          <td>{{ $transaksi->status_transaksi }}</td>
          <td>
            @if(auth()->user()->level === 'admin')
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              @endif
              <div class="dropdown-menu">
                <!-- Modal Edit -->
                @if(auth()->user()->level === 'admin')
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $transaksi->id }}">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </a>

                <!-- Form Delete -->
                <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                    <i class="bx bx-trash me-1"></i> Delete
                  </button>
                </form>
                @endif
              </div>
            </div>
          </td>
        </tr>

        <!-- Modal Edit -->
        {{-- <div class="modal fade" id="editModal{{ $transaksi->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Transaksi</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="id_pasien{{ $transaksi->id }}" class="form-label">Pasien</label>
                    <select name="id_pasien" class="form-select" required>
                      @foreach ($pasien as $pasien)
                        <option value="{{ $pasien->id_pasien }}" {{ $transaksi->id_pasien == $pasien->id_pasien ? 'selected' : '' }}>{{ $pasien->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="id_obat{{ $transaksi->id }}" class="form-label">Obat</label>
                    <select name="id_obat" class="form-select" required>
                      @foreach ($obat as $item)
                        <option value="{{ $item->id }}" {{ $transaksi->id_obat == $item->id ? 'selected' : '' }}>{{ $item->nama_obat }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="jumlah_obat{{ $transaksi->id }}" class="form-label">Jumlah Obat</label>
                    <input type="number" name="jumlah_obat" class="form-control" id="jumlah_obat{{ $transaksi->id }}" value="{{ $transaksi->jumlah_obat }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="status_transaksi{{ $transaksi->id }}" class="form-label">Status Transaksi</label>
                    <select name="status_transaksi" class="form-select" id="status_transaksi{{ $transaksi->id }}" required>
                      <option value="pending" {{ $transaksi->status_transaksi == 'pending' ? 'selected' : '' }}>Pending</option>
                      <option value="selesai" {{ $transaksi->status_transaksi == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="note{{ $transaksi->id }}" class="form-label">Catatan</label>
                    <textarea name="note" class="form-control">{{ $transaksi->note }}</textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div> --}}

        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
