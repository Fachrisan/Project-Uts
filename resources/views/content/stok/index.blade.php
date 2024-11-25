@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Stok')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Data Stok Obat</span>
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
      <form action="{{ route('stok.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahModalLabel">Tambah Stok Obat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="obat_id" class="form-label">Nama Obat</label>
            <select name="obat_id" class="form-select" required>
              <option value="">Pilih Obat</option>
              @foreach($obats as $obat)
                <option value="{{ $obat->id }}">{{ $obat->nama_obat }} ({{ $obat->jenis_obat }})</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah Stok</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tombol untuk memunculkan modal tambah -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
  Tambah Stok Obat
</button>

<div class="card mt-3">
  <h5 class="card-header">Tabel Stok Obat</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-borderless">
      <thead>
        <tr>
          <th>Nama Obat</th>
          <th>Jenis Obat</th>
          <th>Stok</th>
          <th>Harga</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($stok as $stok)
        <tr>
          <td>{{ $stok->obat->nama_obat }}</td>
          <td>{{ $stok->obat->jenis_obat }}</td>
          <td>{{ $stok->stok }}</td>
          <td>{{ $stok->harga }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <!-- Modal Edit -->
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $stok->id }}">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </a>

                <!-- Form Delete -->
                <form action="{{ route('stok.destroy',$stok->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus stok obat ini?');">
                    <i class="bx bx-trash me-1"></i> Delete
                  </button>
                </form>
              </div>
            </div>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{$stok->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('stok.update',$stok->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Stok Obat</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="obat_id{{$stok->id }}" class="form-label">Nama Obat</label>
                    <select name="obat_id" class="form-select" id="obat_id{{$stok->id }}" required>
                      @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" {{$stok->obat_id == $obat->id ? 'selected' : '' }}>{{ $obat->nama_obat }} ({{ $obat->jenis_obat }})</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="stok{{$stok->id }}" class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" id="stok{{$stok->id }}" value="{{$stok->stok }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="harga{{$stok->id }}" class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" id="harga{{$stok->id }}" value="{{$stok->harga }}" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
