@props(['pageTitle'=>null])

<x-master>
<div class="min-h-full">
  <nav class="sticky top-0 z-30 bg-indigo-600">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <h1 class="text-xl font-extrabold text-white">
              TCT
            </h1>
          </div>
          <div class="hidden md:block">
            <div class="flex items-baseline ml-10 space-x-4">
              <a href="/agent/dashboard" class="px-3 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-500 hover:bg-opacity-75">Dashboard</a>
              <a href="/agent/start-form" class="px-3 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-500 hover:bg-opacity-75">Start Form</a>
              <a href="/agent/submissions" class="px-3 py-2 text-sm font-medium text-white rounded-md hover:bg-indigo-500 hover:bg-opacity-75">My submissions</a>
            </div>
          </div>
        </div>
        <div class="hidden md:block">
          <div class="flex items-center ml-4 md:ml-6">
            <button type="button" class="p-1 text-indigo-200 bg-indigo-600 rounded-full hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
              <span class="sr-only">View notifications</span>
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
              </svg>
            </button>

            <!-- Profile dropdown -->
            <div x-data="{open:false}" class="relative ml-3" x-on:click.away="open=false">
              <div>
                <button
                  x-on:click="open = !open"
                type="button" class="flex items-center max-w-xs text-sm bg-indigo-600 rounded-full focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                  <span class="sr-only">Open user menu</span>
                  <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="">
                </button>
              </div>
              <div x-show="open" x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <a href="/agent/account-setting" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Account Setting</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf

                  <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer" 
                          onclick="event.preventDefault();
                                      this.closest('form').submit();">
                      {{ __('Sign out') }}
                  </a>
              </form>
              </div>
            </div>
          </div>
        </div>
        <div class="flex -mr-2 md:hidden">
          <!-- Mobile menu button -->
          <button type="button" class="inline-flex items-center justify-center p-2 text-indigo-200 bg-indigo-600 rounded-md hover:bg-indigo-500 hover:bg-opacity-75 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg class="block w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg class="hidden w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>
   
  </nav>

  @if ($pageTitle)
  <header class="sticky z-20 bg-white border-b top-16 ">
    <div class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <h1 class="text-lg font-semibold leading-6 text-gray-900">
        {{ $pageTitle }}
      </h1>
    </div>
  </header>
  @endif
  <main>
    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
      {{ $slot }}
    </div>
  </main>
</div>
</x-master>