<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Matpel;
use App\Imports\MatpelImport;
use Maatwebsite\Excel\Facades\Excel;

class MatpelManager extends Component
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
    public $ord;
    public $importFile;

    public function render()
    {
        $matpel = Matpel::orderby($this->sortColumn,$this->sortOrder)->select('*');
        if(!empty($this->searchKeyword)){
            $matpel->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $matpels = $matpel->paginate($this->perPage);

        return view('livewire.master.matpel-manager', [ 'matpels' => $matpels ]);
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
        $this->ord = 0;
        $this->importFile = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code'   => 'required|max:30|alpha_num:ascii|unique:matpel,code',
                'name' => 'required|max:255',
                'ord'  => 'required|integer',
            ]);
            Matpel::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'name' => 'required|max:255',
                'ord'  => 'required|integer',
            ]);
            $matpel = Matpel::find($this->set_id);
            $matpel->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $matpel = Matpel::find($id);
        $this->set_id = $id;
        $this->code = $matpel->code;
        $this->name = $matpel->name;
        $this->ord = $matpel->ord;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Matpel::destroy($this->set_id);
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
        $excel = Excel::import(new MatpelImport, $tmp);

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
