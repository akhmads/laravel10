<div>
    @section('title', 'Siswa')
    <x-flash-alert />
    <div class="card">
        <div class="card-header d-md-flex align-items-center justify-content-between">
            <input type="text" class="form-control shadow-sm" placeholder="Search" style="width: 250px;" wire:model.debounce.500ms="searchKeyword" >
            <div class="d-md-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#SiswaImportModal"><i class="fa-solid fa-file-excel me-2"></i>Import</button>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#SiswaFormModal"><i class="fa fa-plus me-2"></i>Create</button>
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
                <th class="sort" wire:click="sortOrder('name')">Nama {!! $sortLink !!}</th>
                <th style="width:20%;" class="sort" wire:click="sortOrder('nis')">NIS {!! $sortLink !!}</th>
                <th style="width:5%;" class="sort" wire:click="sortOrder('gender')">Gender {!! $sortLink !!}</th>
                <th class="w-px-150">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($siswas as $siswa)
            <tr>
                <td>{{ ($siswas->currentPage()-1) * $siswas->perPage() + $loop->index + 1 }}</td>
                <td class="border-start">{{ $siswa->name }}</td>
                <td class="border-start">{{ $siswa->nis }}</td>
                <td class="border-start">{{ $siswa->gender }}</td>
                <td class="border-start text-center">
                    <button type="button" wire:click="edit('{{ $siswa->id }}')" class="btn btn-xs btn-info me-2" data-bs-toggle="modal" data-bs-target="#SiswaFormModal">Update</button>
                    <button type="button" wire:click="delete('{{ $siswa->id }}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#SiswaDeleteModal">Del</button>
                </td>
            </tr>
            @endforeach

            @for($i=1; $i<=($siswas->perPage()-$siswas->count()); $i++)
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
                {{ $siswas->links('admin.custom-pagination') }}
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div wire:ignore.self class="modal fade" id="SiswaFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" siswa="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Siswa</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="store">
            <div class="modal-body">

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
                    <label class="form-label">NIS</label>
                    <input type="text" wire:model="nis" class="form-control @error('nis') is-invalid @enderror" placeholder="NIS">
                    @error('nis')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select wire:model="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="0">-- Choose --</option>
                        @foreach( ['L','P'] as $gender )
                        <option value="{{ $gender }}">{{ $gender }}</option>
                        @endforeach
                    </select>
                    @error('gender')
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
    <div wire:ignore.self class="modal fade" id="SiswaImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Import Siswa</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="import">
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Excel File</label>
                    <input type="file" wire:model="file"  class="form-control @error('file') is-invalid @enderror" />
                    @error('file')
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
    <div wire:ignore.self class="modal fade" id="SiswaDeleteModal" tabindex="-1" siswa="dialog">
        <div class="modal-dialog" siswa="document">
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
            $('#SiswaFormModal').modal('hide');
            $('#SiswaImportModal').modal('hide');
            $('#SiswaDeleteModal').modal('hide');
        });
    </script>
    @endpush
</div>
