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
    public $guru_id;

    public function render()
    {
        $prodi = Prodi::orderby($this->sortColumn,$this->sortOrder)->with('ketua:id,name');
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
        $this->guru_id = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $this->validate([
                'code'  => 'required|unique:prodi,code',
                'name'  => 'required|max:255',
            ]);
            Prodi::create([
                'code' => $this->code,
                'name' => $this->name,
                'guru_id' => $this->guru_id,
            ]);
        }
        else
        {
            $this->validate([
                'code'  => 'required|unique:prodi,code,'.$this->set_id,
                'name'  => 'required|max:255',
            ]);
            $tp = Prodi::find($this->set_id);
            $tp->update([
                'code' => $this->code,
                'name' => $this->name,
                'guru_id' => $this->guru_id,
            ]);
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
        $this->guru_id = $prodi->guru_id;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Prodi::destroy($this->set_id);
        session()->flash('success','Deleted.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
