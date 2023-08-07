<div>
    <form wire:submit.prevent="store">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Change Profile</h5>
        </div>
        <div class="card-body">
            <x-flash-alert />
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" wire:model="name" />
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Name</label>
                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" />
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Change Profile</button>
            </div>
        </div>
    </div>
    </form>
</div>
