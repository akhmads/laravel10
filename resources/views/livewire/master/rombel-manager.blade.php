<div>
    @section('title', 'Rombongan Belajar')

    <div class="d-md-flex justify-content-between">
        <h2 class="mb-3"><span class="text-muted fw-light">Rombongan /</span> Belajar</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Master Data</a>
                </li>
                <li class="breadcrumb-item active">Rombongan Belajar</li>
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
                <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#KelasImportModal"><i class="fa-solid fa-file-excel me-2"></i>Import</button>
                <button type="button" class="btn btn-outline-info me-2"><i class="fa-solid fa-file-excel me-2"></i>Export</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#KelasModal"><i class="fa fa-plus me-2"></i>Create New</button>
            </div>
        </div>
        <div class="table-responsive text-nowrap" class="position-relative" wire:init="loadTable">
            <div wire:loading class="position-absolute fs-1 top-50 start-50 z-3 text-info">
                <i class="fa fa-spin fa-spinner"></i>
            </div>
            <table class="table card-table table-hover table-striped table-sm">
            <thead>
            <tr class="border-top">
                <th class="w-px-75">No</th>
                <th style="width:14%;" class="sort" wire:click="sortOrder('tapel_code')">Tahun {!! $sortLink !!}</th>
                <th style="width:12%;" class="sort" wire:click="sortOrder('kelas.code')">Code {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('kelas.name')">Kelas {!! $sortLink !!}</th>
                <th style="width:10%;">Siswa</th>
                <th class="w-px-150">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($kelass as $kelas)
            <tr>
                <td>{{ ($kelass->currentPage()-1) * $kelass->perPage() + $loop->index + 1 }}</td>
                <td class="border-start">{{ $kelas->tapel_code }}</td>
                <td class="border-start">{{ $kelas->code }}</td>
                <td class="border-start">{{ $kelas->name }}</td>
                <td class="border-start">{{ $kelas->rombel->count() }}</td>
                <td class="border-start text-center">
                    <button type="button" wire:click="edit('{{ $kelas->id }}')" class="btn btn-xs btn-info me-2" data-bs-toggle="modal" data-bs-target="#KelasModal">Update</button>
                    <button type="button" wire:click="delete('{{ $kelas->id }}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#KelasDeleteModal">Del</button>
                </td>
            </tr>
            @endforeach

            @if(count($kelass)>0)
            @for($i=1; $i<=($kelass->perPage()-$kelass->count()); $i++)
            <tr>
                <td>&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
            </tr>
            @endfor
            @else
            @for($i=1; $i<=$perPage; $i++)
            <tr>
                <td>&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
            </tr>
            @endfor
            @endif

            </tbody>
            </table>

            @if(count($kelass)>0)
            <div class="mt-3">
                {{ $kelass->links('admin.custom-pagination') }}
            </div>
            @endif
        </div>
    </div>

    {{-- Edit --}}
    <div wire:ignore.self class="modal fade" id="KelasModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Kelas</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="store">
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            @inject('tapel', 'App\Models\Tapel')
                            <label class="form-label">Tahun Pelajaran</label>
                            <select wire:model="tapel_code" class="form-select @error('tapel_code') is-invalid @enderror">
                                <option value="">-- Choose --</option>
                                @foreach($tapel::orderBy('code')->get()->pluck('code','code') as $key => $val)
                                <option value="{{ $key }}" @if($key==$tapel_code) selected @endif>{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('tapel_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            @inject('kelas', 'App\Models\Kelas')
                            <label class="form-label">Kelas</label>
                            <select wire:model="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror">
                                <option value="">-- Choose --</option>
                                @foreach($kelas::where('tapel_code','=',$tapel_code)->orderBy('code')->get()->pluck('name','code') as $key => $val)
                                <option value="{{ $key }}" @if($key==$kelas_id) selected @endif>{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
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
     <div wire:ignore.self class="modal fade" id="KelasImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Import Kelas</h5>
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
    <div wire:ignore.self class="modal fade" id="KelasDeleteModal" tabindex="-1" kelas="dialog">
        <div class="modal-dialog" kelas="document">
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
            $('#KelasModal').modal('hide');
            $('#KelasImportModal').modal('hide');
            $('#KelasDeleteModal').modal('hide');
        });
    </script>
    @endpush
</div>
