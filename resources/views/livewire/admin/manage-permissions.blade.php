<div class="space-y-4">
    <div>
        <h1 class="text-xl font-semibold text-indigo-600">Manage {{ $role->name }} permissions</h1>
    </div>
    <ul role="list" class="px-5 border divide-y divide-gray-100 rounded-md">
        <li wire:key="2" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">Create Task</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to create new task
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="create_task" />
            </div>
        </li>
        {{-- <li wire:key="3" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">Edit Task</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to edit task
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="edit_task" />
            </div>
        </li> --}}
        <li wire:key="4" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">Delete Task</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to delete existing tasks
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="delete_task" />
            </div>
        </li>

        <li wire:key="5" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">View Submissions</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to view submissions made by other users
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="view_submissions" />
            </div>
        </li>
        <li wire:key="6" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">Create User</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to create new users
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="create_user" />
            </div>
        </li>
        <li wire:key="7" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">Edit User</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to edit existing users
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="edit_user" />
            </div>
        </li>
        <li wire:key="8" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">Delete User</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to delete existing users
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="delete_user" />
            </div>
        </li>
        <li wire:key="9" class="flex items-center justify-between py-5 gap-x-6">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    <p class="text-sm font-semibold leading-6 text-gray-900">Manage Permissions</p>
                </div>
                <div class="flex items-center mt-1 text-xs leading-5 text-gray-500 gap-x-2">
                    <p class="whitespace-nowrap">
                        Allow {{ $role->name }} to manage permissions of other users
                    </p>
                </div>
            </div>
            <div class="flex items-center flex-none gap-x-4">
                <x-toggle wire:model="manage_permissions" />
            </div>
        </li>
    </ul>
</div>
