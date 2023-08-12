<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prodi;

class ProdiManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $sortColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $searchKeyword = '';
    public $roleFilter = '';
    public $set_id;

    public $code;
    public $name;
    public $guru_code;

    public function render()
    {
        $prodi = Prodi::orderby($this->sortColumn,$this->sortOrder)->with('ketua:code,name');
        if(!empty($this->searchKeyword)){
            $prodi->orWhere('code','like',"%".$this->searchKeyword."%");
            $prodi->orWhere('name','like',"%".$this->searchKeyword."%");
        }
        $prodis = $prodi->paginate(10);

        return view('livewire.master.prodi-manager', [ 'prodis' => $prodis ]);
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
        $this->guru_code = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code'  => 'required|max:30|alpha_num:ascii|unique:prodi,code',
                'name'  => 'required|max:255',
                'guru_code'  => '',
            ]);
            Prodi::create($valid);
        }
        else
        {
            $valid = $this->validate([
                //'code'  => 'required|unique:prodi,code,'.$this->set_id,
                'name'  => 'required|max:255',
                'guru_code'  => '',
            ]);
            $tp = Prodi::find($this->set_id);
            $tp->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $prodi = Prodi::find($id);
        $this->set_id = $id;
        $this->code = $prodi->code;
        $this->name = $prodi->name;
        $this->guru_code = $prodi->guru_code;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Prodi::destroy($this->set_id);
        $this->formReset();
        session()->flash('success','Deleted.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
