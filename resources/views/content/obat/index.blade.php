@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Pasien')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Data Obat</span>
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
      <form action="{{ route('obat.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahModalLabel">Tambah Obat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_obat" class="form-label">Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="jenis_obat" class="form-label">Jensi Obat</label>
            <select name="jenis_obat" class="form-select" required>
              <option value="Tablet">Tablet</option>
              <option value="Kapsul">Kapsul</option>
              <option value="Sirup">Sirup</option>
              <option value="Salep">Salep</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah Obat</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tombol untuk memunculkan modal tambah -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
  Tambah Obat
</button>

<div class="card mt-3">
  <h5 class="card-header">Tabel Obat</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-borderless">
      <thead>
        <tr>
          <th>Nama Obat</th>
          <th>Jenis Obat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($obats as $obat)
        <tr>
          <td>{{ $obat->nama_obat }}</td>
          <td>{{ $obat->jenis_obat }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <!-- Modal Edit -->
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $obat->id }}">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </a>

                <!-- Form Delete -->
                <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="dropdown-item" onclick="return confirm('Apakah Anda yakin ingin menghapus pasien ini?');">
                    <i class="bx bx-trash me-1"></i> Delete
                  </button>
                </form>
              </div>
            </div>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $obat->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Obat</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="nama_obat{{ $obat->id }}" class="form-label">Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" id="nama{{ $obat->id }}" value="{{ $obat->nama_obat }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="jenis_obat{{ $obat->id}}" class="form-label">jenis obat</label>
                    <select name="jenis_obat" class="form-select" id="jenis_obat{{ $obat->id }}" required>
                      <option value="Tablet" {{ $obat->jenis_obat == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                      <option value="Kapsul" {{ $obat->jenis_obat == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                      <option value="Sirup" {{ $obat->jenis_obat == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                      <option value="Salep" {{ $obat->jenis_obat == 'Salep' ? 'selected' : '' }}>Salep</option>
                      <option value="Lainnya" {{ $obat->jenis_obat == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
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
