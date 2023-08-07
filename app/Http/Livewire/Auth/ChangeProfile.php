<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class ChangeProfile extends Component
{
    public $name;
    public $email;

    public function mount()
    {
        $this->name = Auth()->user()->name;
        $this->email = Auth()->user()->email;
    }

    public function render()
    {
        return view('livewire.auth.change-profile');
    }

    public function store()
    {
        $this->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.Auth()->user()->id,
        ]);

        Auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success','Profile has been updated successfully');
    }
}