<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Guru;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;

class GuruManager extends Component
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
    public $gender;
    public $importFile;

    public function render()
    {
        $guru = Guru::orderby($this->sortColumn,$this->sortOrder)->select('*');
        if(!empty($this->searchKeyword)){
            $guru->orWhere('code','like',"%".$this->searchKeyword."%");
            $guru->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $gurus = $guru->paginate($this->perPage);

        return view('livewire.master.guru-manager', [ 'gurus' => $gurus ]);
    }

    public function updated()
    {
        $this->resetPage();
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
        $this->gender = null;
        $this->importFile = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code'  => 'required|max:30|alpha_num:ascii|unique:guru,code',
                'name'  => 'required|max:255',
                'gender'  => 'required',
            ]);
            Guru::create($valid);
        }
        else
        {
            $valid = $this->validate([
                //'nip'  => 'required|unique:guru,code,'.$this->set_id,
                'name'  => 'required|max:255',
                'gender'  => 'required',
            ]);
            $guru = Guru::find($this->set_id);
            $guru->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $guru = Guru::find($id);
        $this->set_id = $id;
        $this->code = $guru->code;
        $this->name = $guru->name;
        $this->gender = $guru->gender;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Guru::destroy($this->set_id);
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
        $excel = Excel::import(new GuruImport, $tmp);

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
