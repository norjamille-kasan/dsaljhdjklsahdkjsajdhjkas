<div x-data class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <div class="flex space-x-4">
                <x-input wire:model.debounce.500ms="search" type="search" class="w-80" placeholder="Search" />
            </div>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <x-button x-on:click="$openModal('createModal')" color="primary" icon="plus">
                New Role
            </x-button>
        </div>
    </div>
    <div class="mt-6">
        <x-table :headers="['Name', '']">
            @forelse ($roles as $role)
                <tr>
                    <x-t-cell>{{ $role->name }}</x-t-cell>
                    <x-t-cell>
                        <div class="flex justify-end space-x-2">
                            <x-button href="{{ route('admin.permissions', ['id' => $role->id]) }}" icon="tag" flat
                                label="Manage Permissions" />
                            <span class="text-gray-300">
                                |
                            </span>
                            <x-button wire:click="edit({{ $role->id }})" color="warning" icon="pencil" flat
                                label="Edit" />
                        </div>
                    </x-t-cell>
                </tr>
            @empty
                <tr>
                    <x-t-cell colspan="2">
                        <div class="flex justify-center">
                            No record found
                        </div>
                    </x-t-cell>
                </tr>
            @endforelse
            <x-slot:footer>
                {{ $roles->links() }}
            </x-slot:footer>
        </x-table>
    </div>
    <div>
        <form id="create" wire:submit.prevent="createRole">
            @csrf
            <x-modal wire:model.defer="createModal">
                <x-card title="Create New Account">
                    <div class="grid gap-3">
                        <x-input wire:model.defer="createForm.name" label="Role Name" placeholder="Enter Role Name" />
                    </div>
                    <x-slot name="footer">
                        <div class="flex justify-end gap-x-4">
                            <x-button flat label="Cancel" x-on:click="close" />
                            <x-button type="submit" spinner="create" color="positive" label="Save" />
                        </div>
                    </x-slot>
                </x-card>
            </x-modal>
        </form>
    </div>
    {{-- <div>
        <form id="edit" wire:submit.prevent="update">
            @csrf
            <x-modal wire:model.defer="editModal">
                <x-card title="Updae Account">
                    <div class="grid gap-3">
                        <x-input wire:model.defer="updateForm.name" label="Name" placeholder="Name" />
                        <x-input wire:model.defer="updateForm.email" label="Email" placeholder="Email" />
                    </div>
                    <x-slot name="footer">
                        <div class="flex justify-end gap-x-4">
                            <x-button flat label="Cancel" x-on:click="close" />
                            <x-button type="submit" spinner="update" color="positive" label="Update" />
                        </div>
                    </x-slot>
                </x-card>
            </x-modal>
        </form>
    </div> --}}
</div>
