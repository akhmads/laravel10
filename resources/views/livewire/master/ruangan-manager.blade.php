<div>
    @section('title', 'Ruangan')

    <div class="d-md-flex justify-content-between">
        <h2 class="mb-3"><span class="text-muted fw-light">Data /</span> Ruangan</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Master Data</a>
                </li>
                <li class="breadcrumb-item active">Ruangan</li>
            </ol>
        </nav>
    </div>

    <x-flash-alert />
    <div class="card">
        <div class="card-header d-md-flex align-items-center justify-content-between">
            <div class="d-md-flex justify-content-start">
                <select class="form-select shadow-sm me-2 w-px-75" wire:model="perPage">
                    @foreach([10,25,50,100] as $val)
                    <option value="{{ $val }}" @if($val==$perPage) selected @endif>{{ $val }}</option>
                    @endforeach
                </select>
                <input type="text" class="form-control shadow-sm" placeholder="Search" style="width: 250px;" wire:model.debounce.500ms="searchKeyword">
            </div>
            <div class="d-md-flex justify-content-end">
                <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#RuanganImportModal"><i class="fa-solid fa-file-excel me-2"></i>Import</button>
                <button type="button" class="btn btn-outline-info me-2"><i class="fa-solid fa-file-excel me-2"></i>Export</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#RuanganModal"><i class="fa fa-plus me-2"></i>Create New</button>
            </div>
        </div>
        <div class="table-responsive text-nowrap" class="position-relative">
            <div wire:loading class="position-absolute fs-1 top-50 start-50 z-3 text-info">
                <i class="fa fa-spin fa-spinner"></i>
            </div>
            <table class="table card-table table-hover table-striped table-sm">
            <thead>
            <tr class="border-top">
                <th class="w-px-75">No</th>
                <th style="width:20%;" class="sort" wire:click="sortOrder('code')">Code {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('name')">Nama {!! $sortLink !!}</th>
                <th style="width:15%;" class="sort" wire:click="sortOrder('kapasitas')">Kapasitas {!! $sortLink !!}</th>
                <th class="w-px-150">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ruangans as $ruangan)
            <tr>
                <td>{{ ($ruangans->currentPage()-1) * $ruangans->perPage() + $loop->index + 1 }}</td>
                <td class="border-start">{{ $ruangan->code }}</td>
                <td class="border-start">{{ $ruangan->name }}</td>
                <td class="border-start">{{ $ruangan->kapasitas }}</td>
                <td class="border-start text-center">
                    <button type="button" wire:click="edit('{{ $ruangan->code }}')" class="btn btn-xs btn-info me-2" data-bs-toggle="modal" data-bs-target="#RuanganModal">Update</button>
                    <button type="button" wire:click="delete('{{ $ruangan->code }}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#RuanganDeleteModal">Del</button>
                </td>
            </tr>
            @endforeach

            @for($i=1; $i<=($ruangans->perPage()-$ruangans->count()); $i++)
            <tr>
                <td>&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
            </tr>
            @endfor
            </tbody>
            </table>
            <div class="mt-3">
                {{ $ruangans->links('admin.custom-pagination') }}
            </div>
        </div>
    </div>

    {{-- Edit --}}
    <div wire:ignore.self class="modal fade" id="RuanganModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" ruangan="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Ruangan</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="store">
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Code</label>
                    <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror" placeholder="Code" {{ empty($set_id) ? '' : 'readonly' }}>
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" wire:model="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" placeholder="Kapasitas">
                    @error('kapasitas')
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

     {{-- Import --}}
     <div wire:ignore.self class="modal fade" id="RuanganImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Import Ruangan</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="import">
            <div class="modal-body">

                <div wire:loading wire:target="import" class="mb-3">
                    <i class="fa fa-spin fa-spinner me-3"></i> Importing...
                </div>
                <div class="mb-3">
                    <label class="form-label">Excel File</label>
                    <input type="file" wire:model="importFile"  class="form-control @error('importFile') is-invalid @enderror" />
                    @error('importFile')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" wire:click="closeModal">Close</button>
            <button type="submit" class="btn btn-primary">Import</button>
            </div>
            </form>
        </div>
        </div>
    </div>

    {{-- Delete --}}
    <div wire:ignore.self class="modal fade" id="RuanganDeleteModal" tabindex="-1" ruangan="dialog">
        <div class="modal-dialog" ruangan="document">
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
            $('#RuanganModal').modal('hide');
            $('#RuanganImportModal').modal('hide');
            $('#RuanganDeleteModal').modal('hide');
        });
    </script>
    @endpush
</div>
