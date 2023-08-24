<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Jadwal;
use App\Imports\JadwalImport;

class JadwalManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $sortColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $searchKeyword = '';
    public $roleFilter = '';
    public $set_id;

    public $tapel_code;
    public $kelas_code;
    public $matpel_code;
    public $guru_code;
    public $ruangan_code;
    public $hari;
    public $jam_awal;
    public $jam_akhir;
    public $importFile;

    public function render()
    {
        $jadwal = Jadwal::select('jadwal.*')
        ->orderby($this->sortColumn,$this->sortOrder)
        ->join('matpel', 'matpel.code', '=', 'jadwal.matpel_code')
        ->join('guru', 'guru.code', '=', 'jadwal.guru_code')
        ->join('ruangan', 'ruangan.code', '=', 'jadwal.ruangan_code')
        ->with('matpel:code,name')
        ->with('guru:code,name')
        ->with('ruangan:code,name');

        if(!empty($this->searchKeyword)){
            $jadwal->orWhere('kelas_code','like',"%".$this->searchKeyword."%");
            $jadwal->orWhere('matpel.name','like',"%".$this->searchKeyword."%");
            $jadwal->orWhere('guru.name','like',"%".$this->searchKeyword."%");
            $jadwal->orWhere('ruangan.name','like',"%".$this->searchKeyword."%");
        }
        $jadwals = $jadwal->paginate($this->perPage);

        return view('livewire.master.jadwal-manager', [ 'jadwals' => $jadwals ]);
    }

    public function sortOrder($columnName="")
    {
        $caretOrder = "up";
        if($this->sortOrder == 'asc'){
            $this->sortOrder = 'desc';
            $caretOrder = "down";
        }else{
            $this->sortOrder = 'asc';
            $caretOrder = "up";
        }
        $this->sortLink = '<i class="sorticon fa-solid fa-caret-'.$caretOrder.'"></i>';
        $this->sortColumn = $columnName;
    }

    public function closeModal()
    {
        $this->formReset();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function formReset()
    {
        $this->set_id = null;
        $this->tapel_code = null;
        $this->kelas_code = null;
        $this->matpel_code = null;
        $this->guru_code = null;
        $this->ruangan_code = null;
        $this->hari = null;
        $this->jam_awal = null;
        $this->jam_akhir = null;
        $this->importFile = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'tapel_code' => [
                    'required',
                    Rule::unique('jadwal')->where(function ($query) {
                        return $query
                          ->where('tapel_code', $this->tapel_code)
                          ->where('kelas_code', $this->kelas_code)
                          ->where('guru_code', $this->guru_code)
                          ->where('hari', $this->hari)
                          ->where('jam_awal', $this->jam_awal);
                     })
                ],
                'kelas_code' => 'required',
                'matpel_code' => 'required',
                'guru_code' => 'required',
                'ruangan_code' => 'required',
                'hari' => 'required',
                'jam_awal' => 'required|integer|min:1',
                'jam_akhir' => 'required|integer|min:1',
            ]);
            Jadwal::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'tapel_code' => [
                    'required',
                    Rule::unique('jadwal')->where(function ($query) {
                        return $query
                          ->where('tapel_code', $this->tapel_code)
                          ->where('kelas_code', $this->kelas_code)
                          ->where('guru_code', $this->guru_code)
                          ->where('hari', $this->hari)
                          ->where('jam_awal', $this->jam_awal);
                     })->ignore($this->set_id)
                ],
                'kelas_code' => 'required',
                'matpel_code' => 'required',
                'guru_code' => 'required',
                'ruangan_code' => 'required',
                'hari' => 'required',
                'jam_awal' => 'required|integer|min:1',
                'jam_akhir' => 'required|integer|min:1',
            ]);
            $jadwal = Jadwal::find($this->set_id);
            $jadwal->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::find($id);
        $this->set_id = $id;
        $this->tapel_code = $jadwal->tapel_code;
        $this->kelas_code = $jadwal->kelas_code;
        $this->matpel_code = $jadwal->matpel_code;
        $this->guru_code = $jadwal->guru_code;
        $this->ruangan_code = $jadwal->ruangan_code;
        $this->hari = $jadwal->hari;
        $this->jam_awal = $jadwal->jam_awal;
        $this->jam_akhir = $jadwal->jam_akhir;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Jadwal::destroy($this->set_id);
        $this->formReset();
        session()->flash('success','Deleted.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function import()
    {
        $valid = $this->validate([
            'importFile' => 'required|max:2048|mimes:xls,xlsx',
        ]);

        $file = $this->importFile->store('/', 'local');
        $tmp = storage_path('app').'/'.$file;
        $excel = Excel::import(new JadwalImport, $tmp);

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
