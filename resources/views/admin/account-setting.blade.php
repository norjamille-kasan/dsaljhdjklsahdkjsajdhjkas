<x-admin page-title="Account Setting">
 
  <div x-data="{
    alert: {{ session()->has('status') ? 'true' : 'false' }},
  }" 
  x-init="setTimeout(() => alert = false, 2000)"
  class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
    <div x-cloak x-show="alert" x-collapse>
      <div  class="w-full p-2 bg-green-100 border border-green-500 rounded-lg">
        <span class="text-green-500">{{ session('status')  }}</span>
    </div>
    </div>
    <div class="p-4 bg-white border sm:p-8 sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="p-4 bg-white border sm:p-8 sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</div>
</x-admin>