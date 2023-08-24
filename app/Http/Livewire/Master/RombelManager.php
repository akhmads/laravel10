<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Imports\RombelImport;

class RombelManager extends Component
{
    use WithPagination, WithFileUploads;

    public $RTL = false;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $sortColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $searchKeyword = '';
    public $roleFilter = '';
    public $set_id;

    public $tapel_code;
    public $kelas_id;
    public $siswa_code;
    public $importFile;

    public function loadTable()
    {
        $this->RTL = true;
    }

    public function render()
    {
        $kelas = Kelas::select('kelas.*')
        ->orderby($this->sortColumn,$this->sortOrder);
        //->with('siswa:code');

        if(!empty($this->searchKeyword)){
            $kelas->orWhere('kelas.code','like',"%".$this->searchKeyword."%");
            $kelas->orWhere('kelas.name','like',"%".$this->searchKeyword."%");
        }
        $kelass = $kelas->paginate($this->perPage);

        return view('livewire.master.rombel-manager', [ 'kelass' => $this->RTL ? $kelass : [] ]);
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
        $this->kelas_id = null;
        $this->siswa_code = null;
        $this->importFile = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'kelas_id' => [
                    'required',
                    Rule::unique('rombel')->where(function ($query) {
                        return $query
                           ->where('kelas_id', $this->kelas_id)
                           ->where('siswa_code', $this->siswa_code);
                     })
                ],
                'siswa_code' => 'required',
                'tapel_code' => 'required',
            ]);
            Rombel::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'kelas_id' => [
                    'required',
                    'max:30',
                    'alpha_num:ascii',
                    Rule::unique('rombel')->where(function ($query) {
                        return $query
                            ->where('kelas_id', $this->kelas_id)
                            ->where('siswa_code', $this->siswa_code);
                     })->ignore($this->set_id)
                ],
                'siswa_code' => 'required',
                'tapel_code' => 'required',
            ]);
            $rombel = Rombel::find($this->set_id);
            $rombel->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $rombel = Rombel::find($id);
        $this->set_id = $id;
        // $this->tapel_code = $rombel->tapel_code;
        // $this->kelas_id = $rombel->kelas_id;
        // $this->siswa_code = $rombel->siswa_code;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Rombel::destroy($this->set_id);
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
        $excel = Excel::import(new RombelImport, $tmp);

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
