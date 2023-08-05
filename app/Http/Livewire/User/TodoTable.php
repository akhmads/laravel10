<?php

namespace App\Http\Livewire\Todo;

use Livewire\Component;
use Livewire\WithPagination;
use App\Todo;

class TodoTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['todoStored' => 'render'];
    public $name;

    public function render()
    {
        $todos = Todo::latest()->paginate(5);
        return view('livewire.todo.todo-table', [ 'todos' => $todos ]);
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

        session()->flash('success','Todo saved.');
    }

    public function destroy($id)
    {

        Todo::destroy($id);
        session()->flash('success','Todo deleted.');
    }
}
