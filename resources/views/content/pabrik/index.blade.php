@extends('layouts/contentNavbarLayout')

@section('title', 'Tables - Basic Tables')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light"></span> Tables
</h4>
<!-- Borderless Table -->
<div class="card">
  <h5 class="card-header">Table Apoteker</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-borderless">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Telpon</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($Pasien as $pasien)
        <tr>
          <td>{{$pasien->nama}}</td>
          <td>{{$pasien->alamat}}</td>
          <td>{{$pasien->telepon}}</td>
          <td>{{$pasien->email}}</td>
          <td>{{$pasien->gender}}</td>
          <td>{{$pasien->status}}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
              </div>
            </div>
          </td>
        </tr>

        @endforeach
      </tbody>
    </table>
  </div>
</div>
<!--/ Borderless Table -->

@endsection
