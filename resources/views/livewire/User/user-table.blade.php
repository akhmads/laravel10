<div>
    <x-flash-alert />
    <table class="table card-table table-hover table-striped">
    <thead>
    <tr class="border-top">
        <th class="w-px-75">No</th>
        <th class="sort" wire:click="sortOrder('name')">Name {!! $sortLink !!}</th>
        <th class="sort" wire:click="sortOrder('email')">Email {!! $sortLink !!}</th>
        <th class="w-px-100">Action</th>
    </tr>
    </thead>
    <tbody class=""> {{-- table-border-bottom-0 --}}
    @foreach($users as $user)
    <tr>
        <td>{{ ($users->currentPage()-1) * $users->perPage() + $loop->index + 1 }}</td>
        <td class="border-start">{{ $user->name }}</td>
        <td class="border-start">{{ $user->email }}</td>
        <td class="border-start text-center"><button wire:click="destroy('{{ $user->id }}')" class="btn btn-xs btn-danger">Delete</button></td>
    </tr>
    @endforeach

    @for($i=1; $i<=($users->perPage()-$users->count()); $i++)
    <tr>
        <td>&nbsp;</td>
        <td class="border-start">&nbsp;</td>
        <td class="border-start">&nbsp;</td>
        <td class="border-start">&nbsp;</td>
    </tr>
    @endfor
    </tbody>
    </table>
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
