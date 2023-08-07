<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;

class ChangeAvatar extends Component
{
    use WithFileUploads;

    public $avatar;

    public function render()
    {
        return view('livewire.auth.change-avatar');
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:2048|mimes:jpg,jpeg,png,webp,svg,gif',
        ]);

        $filename = $this->avatar->store('/', 'avatar_disk');
        Auth()->user()->update([
            'avatar' => $filename
        ]);

        $this->avatar = NULL;
    }
}
