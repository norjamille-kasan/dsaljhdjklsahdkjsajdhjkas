<?php

namespace App\Http\Livewire\Companies;

use App\Models\Company;
use App\Services\CompanyService;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Manage extends Component
{
    use WithPagination,Actions;

    public $search = '';

    public $queryString = [
        'search' => ['except' => ''],
    ];

    public $createModal = false;

    public $editModal = false;

    public $createForm = [
        'name' => '',
    ];

    public $updateForm = [
        'id' => '',
        'name' => '',
    ];

    public function validateCreateForm()
    {
        $this->validate([
            'createForm.name' => 'required|unique:companies,name',
        ], [], [
            'createForm.name' => 'Name',
        ]);
    }

    public function validateUpdateForm()
    {
        $this->validate([
            'updateForm.name' => 'required|unique:companies,name,'.$this->updateForm['id'],
        ], [], [
            'updateForm.name' => 'Name',
        ]);
    }

    public function render()
    {
        return view('livewire.companies.manage', [
            'companies' => Company::query()
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                })
                ->withCount('segments')
                ->paginate(10),
        ]);
    }

    public function create()
    {
        $this->validateCreateForm();

        (new CompanyService())->createCompany($this->createForm['name']);

        $this->createModal = false;
        $this->createForm = [
            'name' => '',
        ];

        $this->dialog()->success(
            $title = 'Success',
            $description = 'New company has been created successfully.'
        );
    }

    public function edit(Company $company)
    {
        $this->updateForm = [
            'id' => $company->id,
            'name' => $company->name,
        ];

        $this->editModal = true;
    }

    public function update()
    {
        $this->validateUpdateForm();

        (new CompanyService())->updateCompany(Company::find($this->updateForm['id']), $this->updateForm['name']);

        $this->editModal = false;
        $this->updateForm = [
            'id' => '',
            'name' => '',
        ];

        $this->dialog()->success(
            $title = 'Success',
            $description = 'Company has been updated successfully.'
        );
    }
}
