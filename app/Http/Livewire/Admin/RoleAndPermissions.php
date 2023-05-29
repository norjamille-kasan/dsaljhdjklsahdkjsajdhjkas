<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
class RoleAndPermissions extends Component
{
    use WithPagination, Actions;

    public $search = '';

    public $queryString = [
        'search' => ['except' => ''],
    ];

    public $createForm = [
        'name' => '',
    ];

    public $createModal = false;

    public function render()
    {
        return view('livewire.admin.role-and-permissions',[
            'roles' => Role::query()
                    ->when($this->search, function($query){
                        return $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->paginate(10),
        ]);
    }

    public function createRole()
    {
        $this->validate([
            'createForm.name' => 'required|unique:roles,name',
        ]);

        Role::create([
            'name' => $this->createForm['name'],
        ]);

        $this->createForm = [
            'name' => '',
        ];

        $this->notification()->success(
            $title = 'Role Created',
            $description = 'Role has been created successfully.'
        );
    }
}
