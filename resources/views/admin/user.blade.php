
@extends('admin.layouts.main')

@section('title', 'Home')

@section('content')

  <h2><span class="text-muted fw-light">User /</span> Manager</h2>

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        {{-- <h5 class="card-title m-0 me-2">User Master</h5> --}}
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#UserCreateModal"><i class="fa fa-plus me-2"></i>Create New</button>
    </div>
    <div class="table-responsive text-nowrap">
        @livewire('user.user-table')
    </div>
  </div>

@endsection
