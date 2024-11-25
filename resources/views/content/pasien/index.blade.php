@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Pasien')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Data Pelanggan</span>
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
      <form action="{{ route('pasien.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahModalLabel">Tambah Pelanggan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" name="telepon" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-select" required>
              <option value="Laki-Laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah Pasien</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tombol untuk memunculkan modal tambah -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
  Tambah Pelanggan
</button>

<div class="card mt-3">
  <h5 class="card-header">Tabel Pelanggan</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-borderless">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Telepon</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($Pasien as $pasien)
        <tr>
          <td>{{ $pasien->nama }}</td>
          <td>{{ $pasien->alamat }}</td>
          <td>{{ $pasien->telepon }}</td>
          <td>{{ $pasien->email }}</td>
          <td>{{ $pasien->gender }}</td>
          <td>{{ $pasien->status }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <!-- Modal Edit -->
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal{{ $pasien->id_pasien }}">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </a>

                <!-- Form Delete -->
                <form action="{{ route('pasien.destroy', $pasien->id_pasien) }}" method="POST" style="display:inline;">
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
        <div class="modal fade" id="editModal{{ $pasien->id_pasien }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form action="{{ route('pasien.update', $pasien->id_pasien) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Pelanggan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="nama{{ $pasien->id_pasien }}" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama{{ $pasien->id_pasien }}" value="{{ $pasien->nama }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="alamat{{ $pasien->id_pasien }}" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat{{ $pasien->id_pasien }}" value="{{ $pasien->alamat }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="telepon{{ $pasien->id_pasien }}" class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" id="telepon{{ $pasien->id_pasien }}" value="{{ $pasien->telepon }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="email{{ $pasien->id_pasien }}" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email{{ $pasien->id_pasien }}" value="{{ $pasien->email }}" required>
                  </div>
                  <div class="mb-3">
                    <label for="gender{{ $pasien->id_pasien }}" class="form-label">Gender</label>
                    <select name="gender" class="form-select" id="gender{{ $pasien->id_pasien }}" required>
                      <option value="Laki-Laki" {{ $pasien->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                      <option value="Perempuan" {{ $pasien->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="status{{ $pasien->id_pasien }}" class="form-label">Status</label>
                    <select name="status" class="form-select" id="status{{ $pasien->id_pasien }}" required>
                      <option value="Active" {{ $pasien->status == 'Active' ? 'selected' : '' }}>Active</option>
                      <option value="Inactive" {{ $pasien->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
