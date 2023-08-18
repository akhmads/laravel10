<div>
    @section('title', 'Program Studi')

    <div class="d-md-flex justify-content-between">
        <h2 class="mb-3"><span class="text-muted fw-light">Program /</span> Studi</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Master Data</a>
                </li>
                <li class="breadcrumb-item active">Program Studi</li>
            </ol>
        </nav>
    </div>

    <x-flash-alert />
    <div class="card">
        <div class="card-header d-md-flex align-items-center justify-content-between">
            <input type="text" class="form-control shadow-sm" placeholder="Search" style="width: 250px;" wire:model.debounce.500ms="searchKeyword" >
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ProdiModal"><i class="fa fa-plus me-2"></i>Create New</button>
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
                <th class="sort" wire:click="sortOrder('name')">Program Studi {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('guru.name')">Ketua Jurusan {!! $sortLink !!}</th>
                <th class="w-px-150">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prodis as $prodi)
            <tr>
                <td>{{ ($prodis->currentPage()-1) * $prodis->perPage() + $loop->index + 1 }}</td>
                <td class="border-start">{{ $prodi->code }}</td>
                <td class="border-start">{{ $prodi->name }}</td>
                <td class="border-start">{{ $prodi->ketua->name ?? '' }}</td>
                <td class="border-start text-center">
                    <button type="button" wire:click="edit('{{ $prodi->code }}')" class="btn btn-xs btn-info me-2" data-bs-toggle="modal" data-bs-target="#ProdiModal">Update</button>
                    <button type="button" wire:click="delete('{{ $prodi->code }}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#ProdiDeleteModal">Del</button>
                </td>
            </tr>
            @endforeach

            @for($i=1; $i<=($prodis->perPage()-$prodis->count()); $i++)
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
                {{ $prodis->links('admin.custom-pagination') }}
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div wire:ignore.self class="modal fade" id="ProdiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" prodi="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Tahun Pelajaran</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="store">
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Kode</label>
                    <input type="text" wire:model="code" class="form-control @error('code') is-invalid @enderror" placeholder="Kode" {{ empty($set_id) ? '' : 'readonly' }}>
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Prodi</label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Prodi">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    @inject('guru', 'App\Models\Guru')
                    <label class="form-label">Ketua Jurusan</label>
                    <select wire:model="guru_code" class="form-select @error('guru_code') is-invalid @enderror">
                        <option value="">-- Choose --</option>
                        @foreach($guru::orderBy('name')->get()->pluck('name','code') as $key => $val)
                        <option value="{{ $key }}" @if($key==$guru_code) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('guru_code')
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
    <div wire:ignore.self class="modal fade" id="ProdiDeleteModal" tabindex="-1" prodi="dialog">
        <div class="modal-dialog" prodi="document">
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
            $('#ProdiModal').modal('hide');
            $('#ProdiDeleteModal').modal('hide');
        });
    </script>
    @endpush
</div>
