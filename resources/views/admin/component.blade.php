
@extends('admin.layouts.main')

@section('title', 'Component')

@section('content')

  <x-flash-alert />

  <h1 class="mb-3"><span class="text-muted fw-light">Auth /</span> Components</h1>

  <div class="row">
    <div class="col-md-4">
      @livewire('auth.change-profile')
    </div>
    <div class="col-md-4">
      @livewire('auth.change-avatar')
    </div>
    <div class="col-md-4">
      @livewire('auth.change-password')
    </div>
  </div>

  <h1 class="mt-5 mb-3"><span class="text-muted fw-light">Other /</span> Example</h1>

  <div class="row">
    <div class="col-md-4 mb-4">
      @livewire('example.input')
    </div>
    <div class="col-md-8 mb-4">
        @livewire('example.tabs')
    </div>
    <div class="col-md-8 mb-4">
        @livewire('example.detail')
    </div>
  </div>

  <h1 class="mt-5 mb-3"><span class="text-muted fw-light">Role /</span> Master</h1>

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Role Master</h5>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#RoleCreateModal"><i class="fa fa-plus me-2"></i>Create New</button>
    </div>
    <div class="table-responsive text-nowrap">
        @livewire('role.role-table')
    </div>
  </div>

@endsection
