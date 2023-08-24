<div>
    @section('title', 'Jadwal')

    <div class="d-md-flex justify-content-between">
        <h2 class="mb-3"><span class="text-muted fw-light">Master /</span> Jadwal</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Master Data</a>
                </li>
                <li class="breadcrumb-item active">Jadwal</li>
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
                <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#JadwalImportModal"><i class="fa-solid fa-file-excel me-2"></i>Import</button>
                <button type="button" class="btn btn-outline-info me-2"><i class="fa-solid fa-file-excel me-2"></i>Export</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#JadwalModal"><i class="fa fa-plus me-2"></i>Create New</button>
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
                <th style="width:14%;" class="sort" wire:click="sortOrder('tapel_code')">Tahun {!! $sortLink !!}</th>
                <th style="width:12%;" class="sort" wire:click="sortOrder('kelas_code')">Kelas {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('matpel.name')">Mata Pelajaran {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('guru.name')">Guru {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('ruangan.name')">Ruangan {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('jam_awal')">Jam Awal {!! $sortLink !!}</th>
                <th class="sort" wire:click="sortOrder('jam_akhir')">Jam Akhir {!! $sortLink !!}</th>
                <th class="w-px-150">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($jadwals as $jadwal)
            <tr>
                <td>{{ ($jadwals->currentPage()-1) * $jadwals->perPage() + $loop->index + 1 }}</td>
                <td class="border-start">{{ $jadwal->tapel_code }}</td>
                <td class="border-start">{{ $jadwal->kelas_code }}</td>
                <td class="border-start">{{ $jadwal->matpel->name ?? '' }}</td>
                <td class="border-start">{{ $jadwal->guru->name ?? '' }}</td>
                <td class="border-start">{{ $jadwal->ruangan_code ?? '' }}</td>
                <td class="border-start">{{ $jadwal->jam_awal }}</td>
                <td class="border-start">{{ $jadwal->jam_akhir }}</td>
                <td class="border-start text-center">
                    <button type="button" wire:click="edit('{{ $jadwal->id }}')" class="btn btn-xs btn-info me-2" data-bs-toggle="modal" data-bs-target="#JadwalModal">Update</button>
                    <button type="button" wire:click="delete('{{ $jadwal->id }}')" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#JadwalDeleteModal">Del</button>
                </td>
            </tr>
            @endforeach

            @for($i=1; $i<=($jadwals->perPage()-$jadwals->count()); $i++)
            <tr>
                <td>&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
                <td class="border-start">&nbsp;</td>
            </tr>
            @endfor
            </tbody>
            </table>
            <div class="mt-3">
                {{ $jadwals->links('admin.custom-pagination') }}
            </div>
        </div>
    </div>

    {{-- Edit --}}
    <div wire:ignore.self class="modal fade" id="JadwalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" jadwal="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Jadwal</h5>
            <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="store">
            <div class="modal-body">

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
                <div class="mb-3">
                    @inject('kelas', 'App\Models\Kelas')
                    <label class="form-label">Kelas</label>
                    <select wire:model="kelas_code" class="form-select @error('kelas_code') is-invalid @enderror">
                        <option value="">-- Choose --</option>
                        @foreach($kelas::where('tapel_code',$tapel_code)->orderBy('name')->get()->pluck('name','code') as $key => $val)
                        <option value="{{ $key }}" @if($key==$kelas_code) selected @endif>{{ $key.' - '.$val }}</option>
                        @endforeach
                    </select>
                    @error('kelas_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    @inject('matpel', 'App\Models\Matpel')
                    <label class="form-label">Mata Pelajaran</label>
                    <select wire:model="matpel_code" class="form-select @error('matpel_code') is-invalid @enderror">
                        <option value="">-- Choose --</option>
                        @foreach($matpel::orderBy('name')->get()->pluck('name','code') as $key => $val)
                        <option value="{{ $key }}" @if($key==$matpel_code) selected @endif>{{ $val.' - '.$key }}</option>
                        @endforeach
                    </select>
                    @error('matpel_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    @inject('guru', 'App\Models\Guru')
                    <label class="form-label">Guru</label>
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
                <div class="mb-3">
                    @inject('ruangan', 'App\Models\Ruangan')
                    <label class="form-label">Ruangan</label>
                    <select wire:model="ruangan_code" class="form-select @error('ruangan_code') is-invalid @enderror">
                        <option value="">-- Choose --</option>
                        @foreach($ruangan::orderBy('name')->get()->pluck('name','code') as $key => $val)
                        <option value="{{ $key }}" @if($key==$ruangan_code) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('ruangan_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Hari</label>
                    <select wire:model="hari" class="form-control @error('hari') is-invalid @enderror">
                        <option value="0">-- Choose --</option>
                        @foreach( ['1'=>'Senin','2'=>'Selasa','3'=>'Rabu','4'=>'Kamis','5'=>'Jumat','6'=>'Sabtu','7'=>'Minggu'] as $key => $val )
                        <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('hari')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jam Awal</label>
                            <input type="number" wire:model="jam_awal" class="form-control @error('jam_awal') is-invalid @enderror" placeholder="Jam Awal">
                            @error('jam_awal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jam Akhir</label>
                            <input type="number" wire:model="jam_akhir" class="form-control @error('jam_akhir') is-invalid @enderror" placeholder="Jam Akhir">
                            @error('jam_akhir')
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
     <div wire:ignore.self class="modal fade" id="JadwalImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Import Jadwal</h5>
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
    <div wire:ignore.self class="modal fade" id="JadwalDeleteModal" tabindex="-1" jadwal="dialog">
        <div class="modal-dialog" jadwal="document">
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
            $('#JadwalModal').modal('hide');
            $('#JadwalImportModal').modal('hide');
            $('#JadwalDeleteModal').modal('hide');
        });
    </script>
    @endpush
</div>
