@props(['headers'=>[]])

<div class="flow-root">
  <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
      <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-50">
            <tr>
              @foreach ($headers as $name)
              <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ $name }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            {{ $slot }}
          </tbody>
        </table>
      </div>
      <div class="pt-2">
        {{ $footer ?? ''  }}
      </div>
    </div>
  </div>
</div>