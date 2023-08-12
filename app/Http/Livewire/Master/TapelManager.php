<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Models\Tapel;

class TapelManager extends Component
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

    public function render()
    {
        $tapel = Tapel::orderby($this->sortColumn,$this->sortOrder)->select('*');
        if(!empty($this->searchKeyword)){
            $tapel->orWhere('tapel','like',"%".$this->searchKeyword."%");
        }
        $tapels = $tapel->paginate(10);

        return view('livewire.master.tapel-manager', [ 'tapels' => $tapels ]);
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

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'code'  => 'required|max:30|alpha_dash|unique:tapel,code',
            ]);
            Tapel::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'code'  => ['required', Rule::unique('tapel')->ignore($this->set_id, 'code')]
            ]);
            $tp = Tapel::find($this->set_id);
            $tp->update($valid);
        }

        $this->formReset();
        session()->flash('success','Saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $tp = Tapel::find($id);
        $this->set_id = $id;
        $this->code = $tp->code;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Tapel::destroy($this->set_id);
        $this->formReset();
        session()->flash('success','Deleted.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
