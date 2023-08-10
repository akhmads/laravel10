<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
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

    public $tapel;

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
        $this->tapel = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $this->validate([
                'tapel'  => 'required|unique:tapel,tapel',
            ]);
            Tapel::create([
                'tapel' => $this->tapel,
            ]);
        }
        else
        {
            $this->validate([
                'tapel'  => 'required|unique:tapel,tapel,'.$this->set_id,
            ]);
            $tp = Tapel::find($this->set_id);
            $tp->update([
                'tapel' => $this->tapel,
            ]);
        }

        $this->formReset();
        session()->flash('success','Data saved.');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $tp = Tapel::find($id);
        $this->set_id = $id;
        $this->tapel = $tp->tapel;
    }

    public function delete($id)
    {
        $this->set_id = $id;
    }

    public function destroy()
    {
        Tapel::destroy($this->set_id);
        session()->flash('success','Deleted.');
        $this->dispatchBrowserEvent('close-modal');
    }
}
