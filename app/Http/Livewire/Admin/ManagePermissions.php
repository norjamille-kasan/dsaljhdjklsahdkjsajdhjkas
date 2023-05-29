<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ManagePermissions extends Component
{
    public $role;
    public $roleId;


    public $create_task;
    public $edit_task;
    public $delete_task;
    public $view_submissions;
    public $create_user;
    public $edit_user;
    public $delete_user;
    public $manage_permissions;
    public $view_reports;
    

    public function mount($roleId)
    {
        $this->roleId = $roleId;
    }
    public function render()
    {
        $this->role = Role::findOrFail($this->roleId);
        $this->create_task = $this->role->hasPermissionTo('create task');
        $this->edit_task = $this->role->hasPermissionTo('edit task');
        $this->delete_task = $this->role->hasPermissionTo('delete task');
        $this->view_submissions = $this->role->hasPermissionTo('view submissions');
        $this->create_user = $this->role->hasPermissionTo('create user');
        $this->edit_user = $this->role->hasPermissionTo('edit user');
        $this->delete_user = $this->role->hasPermissionTo('delete user');
        $this->manage_permissions = $this->role->hasPermissionTo('manage permissions');
        $this->view_reports = $this->role->hasPermissionTo('view reports');
        return view('livewire.admin.manage-permissions');
    }


    public function updatedCreateTask()
    {
        if ($this->create_task) {
            $this->role->givePermissionTo('create task');
        } else {
            $this->role->revokePermissionTo('create task');
        }
    }

    public function updatedEditTask()
    {
        if ($this->edit_task) {
            $this->role->givePermissionTo('edit task');
        } else {
            $this->role->revokePermissionTo('edit task');
        }
    }

    public function updatedDeleteTask()
    {
        if ($this->delete_task) {
            $this->role->givePermissionTo('delete task');
        } else {
            $this->role->revokePermissionTo('delete task');
        }
    }

    public function updatedViewSubmissions()
    {
        if ($this->view_submissions) {
            $this->role->givePermissionTo('view submissions');
        } else {
            $this->role->revokePermissionTo('view submissions');
        }
    }

    public function updatedCreateUser()
    {
        if ($this->create_user) {
            $this->role->givePermissionTo('create user');
        } else {
            $this->role->revokePermissionTo('create user');
        }
    }

    public function updatedEditUser()
    {
        if ($this->edit_user) {
            $this->role->givePermissionTo('edit user');
        } else {
            $this->role->revokePermissionTo('edit user');
        }
    }

    public function updatedDeleteUser()
    {
        if ($this->delete_user) {
            $this->role->givePermissionTo('delete user');
        } else {
            $this->role->revokePermissionTo('delete user');
        }
    }

    public function updatedManagePermissions()
    {
        if ($this->manage_permissions) {
            $this->role->givePermissionTo('manage permissions');
        } else {
            $this->role->revokePermissionTo('manage permissions');
        }
    }

    public function updatedViewReports()
    {
        if ($this->view_reports) {
            $this->role->givePermissionTo('view reports');
        } else {
            $this->role->revokePermissionTo('view reports');
        }
    }
}
