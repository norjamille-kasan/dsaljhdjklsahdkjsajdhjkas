<div x-data class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <div class="flex space-x-4">
                <x-input wire:model.debounce.500ms="search" type="search" class="w-80" placeholder="Search" />
                <x-native-select wire:model="role">
                    <option value="">All</option>
                    <option value="Agent">Agents</option>
                    <option value="Admin">Admin</option>
                </x-native-select>
            </div>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <x-button x-on:click="$openModal('createModal')" color="primary" icon="plus">
                New Account
            </x-button>
        </div>
    </div>
    <div class="mt-6">
        <x-table :headers="['Name', 'Email', 'Role', '']">
            @forelse ($users as $user)
                <tr>
                    <x-t-cell>{{ $user->name }}</x-t-cell>
                    <x-t-cell>{{ $user->email }}</x-t-cell>
                    <x-t-cell>
                        @foreach ($user->roles as $role)
                            @if ($role->name === 'Admin')
                                <x-badge color="green">
                                    {{ $role->name }}
                                </x-badge>
                            @elseif($role->name === 'Agent')
                                <x-badge color="blue">
                                    {{ $role->name }}
                                </x-badge>
                            @endif
                        @endforeach
                    </x-t-cell>
                    <x-t-cell>
                        <div class="flex items-center justify-end space-x-1">
                            <x-button wire:click="edit({{ $user->id }})" color="warning" icon="pencil" flat label="Edit" />
                                <span class="text-gray-300">
                                    |
                                </span>
                                <x-button  x-on:confirm="{
                                title: 'Sure Delete?',
                                icon: 'warning',
                                method: 'delete',
                                params: {{ $user->id }},
                            }" color="red" icon="trash" flat label="Delete" />
                            <span class="text-gray-300">
                                |
                            </span>
                            <x-button x-on:confirm="{
                                title: 'Sure Reset Password?',
                                description: 'This will reset the password to default password (password12345)',
                                icon: 'warning',
                                method: 'resetPassword',
                                params: {{ $user->id }},
                            }" color="blue" icon="key" flat label="Reset Password" />
                        </div>
                    </x-t-cell>
                </tr>
            @empty
                <tr>
                    <x-t-cell colspan="4" >
                        <div class="flex justify-center">
                            No users found
                        </div>
                    </x-t-cell>
                </tr>
            @endforelse
            <x-slot:footer>
                {{ $users->links() }}
            </x-slot:footer>
        </x-table>
    </div>
  <div>
    <form id="create" wire:submit.prevent="create">
        @csrf
        <x-modal wire:model.defer="createModal">
            <x-card title="Create New Account">
                <div class="grid gap-3" >
                    <x-input wire:model.defer="createForm.name" label="Name" placeholder="Name" />
                    <x-input wire:model.defer="createForm.email" label="Email" placeholder="Email" />
                    <x-input wire:model.defer="createForm.password" type="password" label="Password" placeholder="Password" />
                    <x-native-select wire:model.defer="createForm.role" label="Role">
                        <option value="">Select Role</option>
                        <option value="Agent">Agent</option>
                        <option value="Admin">Admin</option>
                    </x-native-select>
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
   <div>
    <form id="edit" wire:submit.prevent="update" >
        @csrf
        <x-modal wire:model.defer="editModal">
            <x-card title="Updae Account">
                <div class="grid gap-3" >
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
   </div>
</div>
