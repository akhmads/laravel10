<div>
    <x-flash-alert />
    
    {{-- <form wire:submit.prevent="store">
        <div class="mb-3">
            <div class="input-group">
                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Add todo name">
                <button class="btn btn-outline-primary" type="submit">Add</button>
            </div>
            @error('name')
            <div class="d-block invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </form> --}}

    <table class="table table-bordered mb-3">
    <thead>
    <tr>
        <th class="w-px-75">No</th>
        <th>Todo</th>
        <th class="w-px-100">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($todos as $todo)
    <tr>
        <td>{{ ($todos->currentPage()-1) * $todos->perPage() + $loop->index + 1 }}</td>
        <td>{{ $todo->name }}</td>
        <td class="text-center"><button wire:click="destroy('{{ $todo->id }}')" class="btn btn-xs btn-danger">Delete</button></td>
    </tr>
    @endforeach

    @for($i=1; $i<=($todos->perPage()-$todos->count()); $i++)
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    @endfor
    </tbody>
    </table>
    {{ $todos->links() }}
</div>
