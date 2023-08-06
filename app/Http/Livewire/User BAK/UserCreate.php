<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class UserCreate extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $password;
    public $avatar;

    public function render()
    {
        return view('livewire.user.user-create');
    }

    public function store()
    {
        $this->validate([
            'name'  => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','string','min:8','regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/'],
            'avatar' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp',
        ]);

        $avatar = $this->avatar->store('/', 'avatar_disk');

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => $avatar,
        ]);

        $this->name = null;
        $this->email = null;
        $this->password = null;

        $this->emit('userStored');

        session()->flash('success','User saved.');
    }
}
