<div>
    @section('title', 'Tahun Pelajaran')

    <div class="d-md-flex justify-content-between">
        <h2 class="mb-3"><span class="text-muted fw-light">Tahun /</span> Pelajaran</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Master Data</a>
                </li>
                <li class="breadcrumb-item active">Tahun Pelajaran</li>
            </ol>
        </nav>
    </div>

    <x-flash-alert />
    <div class="card">
        <div class="card-header d-md-flex align-items-center justify-content-between">
            <input type="text" class="form-control shadow-sm" placeholder="Search" style="width: 250px;" wire:model.debounce.500ms="searchKeyword" >
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#TapelModal"><i class="fa fa-plus me-2"></i>Create New</button>
        </div>
        <div class="table-responsive text-nowrap" class="position-relative">
            <div wire:loading class="position-absolute fs-1 top-50 start-50 z-3 text-info">
                <i class="fa fa-spin fa-spinner"></i>
            </div>
            <table class="table card-table table-hover table-striped table-sm">
            <thead>
            <tr class="border-top">
                <th class="w-px-75">No</th>
                <th class="sort" wire:click="sortOrder('code')">Tahun Pelajaran {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('active')">Active {!! $sortLink !!}</th>
                <th class="w-px-150">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tapels as $tapel)
            <tr>
                <td>{{ ($tapels->currentPage()-1) * $tapels->perPage() + $loop->index + 1 }}</td>
                <td class="border-start">{{ $tapel->code }}</td>
                <td class="border-start">{{ $tapel->active }}</td>
                <td class="border-start text-center">
                    <button type="button" wire:click="edit('{{ $tapel->code }}')" class="btn btn-xs btn-info me-2" data-bs-toggle="modal" data-bs-target="#TapelModal">Update</button>
                    <button type="button" wire:click="delete('{{ $tapel->code }}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#TapelDeleteModal">Del</button>
                </td>
            </tr>
            @endforeach

            @for($i=1; $i<=($tapels->perPage()-$tapels->count()); $i++)
            <tr>
                <td>&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
            </tr>
            @endfor
            </tbody>
            </table>
            <div class="mt-3">
                {{ $tapels->links('admin.custom-pagination') }}
            </div>
        </div>
    </div>

    {{-- Edit --}}
    <div wire:ignore.self class="modal fade" id="TapelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" tapel="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Tahun Pelajaran</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="store">
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Tahun Pelajaran</label>
                    <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror" placeholder="Tahun Pelajaran" {{ empty($set_id) ? '' : 'readonly' }}>
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" wire:click="closeModal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
        </div>
    </div>

    {{-- Delete --}}
    <div wire:ignore.self class="modal fade" id="TapelDeleteModal" tabindex="-1" tapel="dialog">
        <div class="modal-dialog" tapel="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirm</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-danger close-modal" data-bs-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#TapelModal').modal('hide');
            $('#TapelDeleteModal').modal('hide');
        });
    </script>
    @endpush
</div>
