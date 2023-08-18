<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Ruangan;
use App\Imports\RuanganImport;
use Maatwebsite\Excel\Facades\Excel;

class RuanganManager extends Component
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

    public $code;
    public $name;
    public $kapasitas;
    public $importFile;

    public function render()
    {
        $ruangan = Ruangan::orderby($this->sortColumn,$this->sortOrder)->select('*');
        if(!empty($this->searchKeyword)){
            $ruangan->orWhere('code','like',"%".$this->searchKeyword."%");
            $ruangan->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $ruangans = $ruangan->paginate($this->perPage);

        return view('livewire.master.ruangan-manager', [ 'ruangans' => $ruangans ]);
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
        $this->code = null;
        $this->name = null;
        $this->kapasitas = null;
        $this->importFile = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code'   => 'required|max:30|alpha_num:ascii|unique:ruangan,code',
                'name' => 'required|max:255',
                'kapasitas'  => 'required|integer',
            ]);
            Ruangan::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required|max:255',
                'kapasitas'  => 'required|integer',
            ]);
            $ruangan = Ruangan::find($this->set_id);
            $ruangan->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::find($id);
        $this->set_id = $id;
        $this->code = $ruangan->code;
        $this->name = $ruangan->name;
        $this->kapasitas = $ruangan->kapasitas;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Ruangan::destroy($this->set_id);
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
        $excel = Excel::import(new RuanganImport, $tmp);

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
