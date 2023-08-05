<?php

namespace App\Http\Livewire\Todo;

use Livewire\Component;
use App\Todo;

class TodoCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.todo.todo-create');
    }

    public function store()
    {
        $this->validate([
            'name'  => 'required|max:100',
        ]);

        Todo::create([
            'name' => $this->name,
            'status' => '0',
        ]);

        $this->name = NULL;

        $this->emit('todoStored');

        session()->flash('success','Todo saved.');
    }
}
