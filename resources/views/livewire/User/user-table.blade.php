<div>
    <x-flash-alert />
    <table class="table card-table table-hover table-striped">
    <thead>
    <tr class="border-top">
        <th class="w-px-75">No</th>
        <th class="w-px-75">Avatar</th>
        <th style="width:40%;" class="sort" wire:click="sortOrder('name')">Name {!! $sortLink !!}</th>
        <th class="sort" wire:click="sortOrder('email')">Email {!! $sortLink !!}</th>
        <th class="w-px-100">Action</th>
    </tr>
    </thead>
    <tbody class=""> {{-- table-border-bottom-0 --}}
    @foreach($users as $user)
    <tr>
        <td>{{ ($users->currentPage()-1) * $users->perPage() + $loop->index + 1 }}</td>
        <td class="border-start py-1 text-center"><img src="{{ asset('avatar/'.$user->avatar) }}" alt="" class="w-px-auto h-px-30 rounded-circle" /></td>
        <td class="border-start">{{ $user->name }}</td>
        <td class="border-start">{{ $user->email }}</td>
        <td class="border-start text-center"><button type="button" wire:click="setID('{{ $user->id }}')" data-bs-toggle="modal" data-bs-target="#userDeleteModal" class="btn btn-xs btn-danger">Delete</button></td>
    </tr>
    @endforeach

    @for($i=1; $i<=($users->perPage()-$users->count()); $i++)
    <tr>
        <td>&nbsp;</td>
        <td class="border-start">&nbsp;</td>
        <td class="border-start">&nbsp;</td>
        <td class="border-start">&nbsp;</td>
        <td class="border-start">&nbsp;</td>
    </tr>
    @endfor
    </tbody>
    </table>
    <div class="mt-3">
        {{ $users->links('admin.custom-pagination') }}
    </div>

    <div wire:ignore.self class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="xxx" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirm</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click.prevent="destroy()" class="btn btn-danger close-modal" data-bs-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>
