<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Guru;

class GuruManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $sortColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $searchKeyword = '';
    public $roleFilter = '';
    public $set_id;

    public $name;
    public $nip;
    public $gender;

    public function render()
    {
        $guru = Guru::orderby($this->sortColumn,$this->sortOrder)->select('*');
        if(!empty($this->searchKeyword)){
            $guru->orWhere('name','like',"%".$this->searchKeyword."%");
            $guru->orWhere('nip','like',"%".$this->searchKeyword."%");
        }
        $gurus = $guru->paginate(10);

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
        $this->nip = null;
        $this->name = null;
        $this->gender = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $this->validate([
                'nip'  => 'required|unique:guru,nip',
                'name'  => 'required|max:255',
                'gender'  => 'required',
            ]);
            Guru::create([
                'nip' => $this->nip,
                'name' => $this->name,
                'gender' => $this->gender,
            ]);
        }
        else
        {
            $this->validate([
                'nip'  => 'required|unique:guru,nip,'.$this->set_id,
                'name'  => 'required|max:255',
                'gender'  => 'required',
            ]);
            $guru = Guru::find($this->set_id);
            $guru->update([
                'nip' => $this->nip,
                'name' => $this->name,
                'gender' => $this->gender,
            ]);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $guru = Guru::find($id);
        $this->set_id = $id;
        $this->nip = $guru->nip;
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
}
