<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Kelas;
use App\Imports\KelasImport;

class KelasManager extends Component
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
    public $prodi_code;
    public $code;
    public $name;
    public $importFile;

    public function render()
    {
        $kelas = Kelas::select('kelas.*')
        ->orderby($this->sortColumn,$this->sortOrder)
        ->join('prodi', 'prodi.code', '=', 'kelas.prodi_code')
        ->with('prodi:code,name');

        if(!empty($this->searchKeyword)){
            $kelas->orWhere('kelas.code','like',"%".$this->searchKeyword."%");
            $kelas->orWhere('kelas.name','like',"%".$this->searchKeyword."%");
            $kelas->orWhere('prodi.name','like',"%".$this->searchKeyword."%");
        }
        $kelass = $kelas->paginate($this->perPage);

        return view('livewire.master.kelas-manager', [ 'kelass' => $kelass ]);
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
        $this->prodi_code = null;
        $this->code = null;
        $this->name = null;
        $this->importFile = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code' => [
                    'required',
                    'max:30',
                    'alpha_num:ascii',
                    //'unique:kelas,code'
                    Rule::unique('kelas')->where(function ($query) {
                        return $query->where('code', $this->code)
                           ->where('tapel_code', $this->tapel_code)
                           ->where('prodi_code', $this->prodi_code);
                     })
                ],
                'name' => 'required|max:255',
                'tapel_code' => 'required',
                'prodi_code' => 'required',
            ]);
            Kelas::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'code' => [
                    'required',
                    'max:30',
                    'alpha_num:ascii',
                    Rule::unique('kelas')->where(function ($query) {
                        return $query->where('code', $this->code)
                           ->where('tapel_code', $this->tapel_code)
                           ->where('prodi_code', $this->prodi_code);
                     })->ignore($this->set_id)
                ],
                'name' => 'required|max:255',
                'tapel_code' => 'required',
                'prodi_code' => 'required',
            ]);
            $kelas = Kelas::find($this->set_id);
            $kelas->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $kelas = Kelas::find($id);
        $this->set_id = $id;
        $this->code = $kelas->code;
        $this->name = $kelas->name;
        $this->tapel_code = $kelas->tapel_code;
        $this->prodi_code = $kelas->prodi_code;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Kelas::destroy($this->set_id);
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
        $excel = Excel::import(new KelasImport, $tmp);

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
