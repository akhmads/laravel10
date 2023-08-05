<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.role.role-create');
    }

    public function store()
    {
        $this->validate([
            'name'  => 'required|max:100',
        ]);

        $role = Role::create([
            'name' => $this->name,
        ]);

        $this->name = null;

        $this->emit('roleStored');

        session()->flash('success','Role saved.');
    }
}
