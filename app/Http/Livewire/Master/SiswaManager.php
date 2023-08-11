<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;

class SiswaManager extends Component
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
    public $nis;
    public $gender;

    public function render()
    {
        $siswa = Siswa::orderby($this->sortColumn,$this->sortOrder)->select('*');
        if(!empty($this->searchKeyword)){
            $siswa->orWhere('name','like',"%".$this->searchKeyword."%");
            $siswa->orWhere('nis','like',"%".$this->searchKeyword."%");
        }
        $siswas = $siswa->paginate(10);

        return view('livewire.master.siswa-manager', [ 'siswas' => $siswas ]);
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
        $this->nis = null;
        $this->name = null;
        $this->gender = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        $rules = [
            'nis'  => 'required|unique:siswa,nis',
            'name'  => 'required|max:255',
            'gender'  => '',
        ];

        if(empty($this->set_id))
        {
            $valid = $this->validate($rules);
            Siswa::create($valid);
        }
        else
        {
            $rules['nis'] = 'required|unique:siswa,nis,'.$this->set_id;
            $valid = $this->validate($rules);

            $siswa = Siswa::find($this->set_id);
            $siswa->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $siswa = Siswa::find($id);
        $this->set_id = $id;
        $this->nis = $siswa->nis;
        $this->name = $siswa->name;
        $this->gender = $siswa->gender;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Siswa::destroy($this->set_id);
        $this->formReset();
        session()->flash('success','Deleted.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
