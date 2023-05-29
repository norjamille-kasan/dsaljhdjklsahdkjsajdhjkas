<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class Manage extends Component
{
    use WithPagination,Actions;

    public $search = '';

    public $role = '';

    public $createModal = false;

    public $editModal = false;

    public $roles = [];

    public $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
    ];

    public $createForm = [
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => '',
    ];

    public $updateForm = [
        'id' => '',
        'name' => '',
        'email' => '',
    ];

    public function validateCreateForm()
    {
        $this->validate([
            'createForm.name' => 'required',
            'createForm.email' => 'required|email|unique:users,email',
            'createForm.password' => 'required|min:8',
            'createForm.role' => 'required|in:'.implode(',', $this->roles->pluck('name')->toArray()),
        ], [], [
            'createForm.name' => 'Name',
            'createForm.email' => 'Email',
            'createForm.password' => 'Password',
            'createForm.role' => 'Role',
        ]);
    }

    public function validateUpdateForm()
    {
        $this->validate([
            'updateForm.name' => 'required',
            'updateForm.email' => 'required|email|unique:users,email,'.$this->updateForm['id'],
        ], [], [
            'updateForm.name' => 'Name',
            'updateForm.email' => 'Email',
        ]);
    }

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.user.manage', [
            'users' => User::query()
                    ->when($this->search != '', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                    })
                    ->when($this->role != '', function ($query) {
                        $query->role($this->role);
                    })
                    ->with('roles')
                    ->paginate(10),
        ]);
    }

    public function edit(User $user)
    {
        $this->updateForm = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        $this->editModal = true;
    }

    public function create()
    {
        $this->validateCreateForm();

        $user = (new UserService)->createAccount(
            $this->createForm['name'],
            $this->createForm['email'],
            $this->createForm['password'],
            $this->createForm['role'],
        );

        $this->createModal = false;
        $this->createForm = [
            'name' => '',
            'email' => '',
            'password' => '',
            'role' => '',
        ];
        $this->dialog()->success(
            $title = 'Success',
            $description = 'New account has been created successfully.'
        );
    }

    public function update()
    {
        $this->validateUpdateForm();

        $user = (new UserService)->updateAccount(
            User::find($this->updateForm['id']),
            $this->updateForm['name'],
            $this->updateForm['email'],
        );

        $this->editModal = false;
        $this->updateForm = [
            'id' => '',
            'name' => '',
            'email' => '',
        ];
        $this->dialog()->success(
            $title = 'Success',
            $description = 'Account has been updated successfully.'
        );
    }

    public function resetPassword($id)
    {
        $user = User::find($id);
        (new UserService)->resetPassword($user);
        $this->dialog()->success(
            $title = 'Success',
            $description = 'Password has been reset successfully.'
        );
    }

    public function delete($id)
    {
        $user = User::find($id);
        (new UserService)->deleteAccount($user);
        $this->dialog()->success(
            $title = 'Success',
            $description = 'Account has been deleted successfully.'
        );
    }
}
