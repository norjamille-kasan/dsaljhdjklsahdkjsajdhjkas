<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class ManagePermissions extends Component
{
    public $user;
    public $userId;


    public $create_task;
    public $edit_task;
    public $delete_task;
    public $view_submissions;
    public $create_user;
    public $edit_user;
    public $delete_user;
    public $manage_permissions;
    public $view_reports;
    

    public function mount($userId)
    {
        $this->userId = $userId;
    }
    public function render()
    {
        $this->user = User::findOrFail($this->userId);
        $this->create_task = $this->user->hasPermissionTo('create task');
        $this->edit_task = $this->user->hasPermissionTo('edit task');
        $this->delete_task = $this->user->hasPermissionTo('delete task');
        $this->view_submissions = $this->user->hasPermissionTo('view submissions');
        $this->create_user = $this->user->hasPermissionTo('create user');
        $this->edit_user = $this->user->hasPermissionTo('edit user');
        $this->delete_user = $this->user->hasPermissionTo('delete user');
        $this->manage_permissions = $this->user->hasPermissionTo('manage permissions');
        $this->view_reports = $this->user->hasPermissionTo('view reports');
        return view('livewire.admin.manage-permissions');
    }


    public function updatedCreateTask()
    {
        if ($this->create_task) {
            $this->user->givePermissionTo('create task');
        } else {
            $this->user->revokePermissionTo('create task');
        }
    }

    public function updatedEditTask()
    {
        if ($this->edit_task) {
            $this->user->givePermissionTo('edit task');
        } else {
            $this->user->revokePermissionTo('edit task');
        }
    }

    public function updatedDeleteTask()
    {
        if ($this->delete_task) {
            $this->user->givePermissionTo('delete task');
        } else {
            $this->user->revokePermissionTo('delete task');
        }
    }

    public function updatedViewSubmissions()
    {
        if ($this->view_submissions) {
            $this->user->givePermissionTo('view submissions');
        } else {
            $this->user->revokePermissionTo('view submissions');
        }
    }

    public function updatedCreateUser()
    {
        if ($this->create_user) {
            $this->user->givePermissionTo('create user');
        } else {
            $this->user->revokePermissionTo('create user');
        }
    }

    public function updatedEditUser()
    {
        if ($this->edit_user) {
            $this->user->givePermissionTo('edit user');
        } else {
            $this->user->revokePermissionTo('edit user');
        }
    }

    public function updatedDeleteUser()
    {
        if ($this->delete_user) {
            $this->user->givePermissionTo('delete user');
        } else {
            $this->user->revokePermissionTo('delete user');
        }
    }

    public function updatedManagePermissions()
    {
        if ($this->manage_permissions) {
            $this->user->givePermissionTo('manage permissions');
        } else {
            $this->user->revokePermissionTo('manage permissions');
        }
    }

    public function updatedViewReports()
    {
        if ($this->view_reports) {
            $this->user->givePermissionTo('view reports');
        } else {
            $this->user->revokePermissionTo('view reports');
        }
    }
}
