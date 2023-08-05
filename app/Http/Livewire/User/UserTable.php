<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'userStored' => 'render',
        'userUpdated' => 'render',
        'userDeleted' => 'render',
    ];
    public $orderColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $name;
    public $email;
    public $selectedID;

    public function render()
    {
        $users = User::orderby($this->orderColumn,$this->sortOrder)->select('*');
        $users = $users->paginate(5);

        return view('livewire.user.user-table', [ 'users' => $users ]);
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
        $this->orderColumn = $columnName;

    }

    public function setID($id)
    {

        $this->selectedID = $id;
    }

    public function destroy()
    {

        User::destroy($this->selectedID);
        $this->emit('userDeleted');
        session()->flash('success','User deleted.');
    }
}
