<x-admin page-title="{{ $company->name }}">
  @livewire('companies.company',[
    'company' => $company
  ])
</x-admin>