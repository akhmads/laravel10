<div>
    @section('title', 'Guru')
    <x-flash-alert />
    <div class="card">
        <div class="card-header d-md-flex align-items-center justify-content-between">
            <input type="text" class="form-control shadow-sm" placeholder="Search" style="width: 250px;" wire:model="searchKeyword" >
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#GuruModal"><i class="fa fa-plus me-2"></i>Create New</button>
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
                <th style="width:20%;" class="sort" wire:click="sortOrder('nip')">NIP {!! $sortLink !!}</th>
                <th style="width:5%;" class="sort" wire:click="sortOrder('gender')">Gender {!! $sortLink !!}</th>
                <th class="w-px-150">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gurus as $guru)
            <tr>
                <td>{{ ($gurus->currentPage()-1) * $gurus->perPage() + $loop->index + 1 }}</td>
                <td class="border-start">{{ $guru->name }}</td>
                <td class="border-start">{{ $guru->nip }}</td>
                <td class="border-start">{{ $guru->gender }}</td>
                <td class="border-start text-center">
                    <button type="button" wire:click="edit('{{ $guru->id }}')" class="btn btn-xs btn-info me-2" data-bs-toggle="modal" data-bs-target="#GuruModal">Update</button>
                    <button type="button" wire:click="delete('{{ $guru->id }}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#GuruDeleteModal">Del</button>
                </td>
            </tr>
            @endforeach

            @for($i=1; $i<=($gurus->perPage()-$gurus->count()); $i++)
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
                {{ $gurus->links('admin.custom-pagination') }}
            </div>
        </div>
    </div>

    {{-- Edit --}}
    <div wire:ignore.self class="modal fade" id="GuruModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" guru="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Guru</h5>
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
                    <label class="form-label">NIP</label>
                    <input type="text" wire:model="nip" class="form-control @error('nip') is-invalid @enderror" placeholder="NIP">
                    @error('nip')
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

    {{-- Delete --}}
    <div wire:ignore.self class="modal fade" id="GuruDeleteModal" tabindex="-1" guru="dialog">
        <div class="modal-dialog" guru="document">
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
            $('#GuruModal').modal('hide');
            $('#GuruDeleteModal').modal('hide');
        });
    </script>
    @endpush
</div>
