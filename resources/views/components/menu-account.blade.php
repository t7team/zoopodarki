<div class="flex items-center justify-between space-x-4">
  @guest

    <livewire:auth.in />

  @else
    <div x-data="{ open: false }" @click.outside="open = false" class="relative">

      <button @mouseenter="open = true" class="flex items-center w-auto p-1 text-xs rounded-lg group focus:outline-none">

        <svg class="text-gray-600 w-7 h-7 focus:text-orange-500 focus:outline-none" xmlns="http://www.w3.org/2000/svg"
          fill="none" viewBox="0 0 24 24">
          <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M18.14 21.62c-.88.26-1.92.38-3.14.38H9c-1.22 0-2.26-.12-3.14-.38.22-2.6 2.89-4.65 6.14-4.65 3.25 0 5.92 2.05 6.14 4.65Z" />
          <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M15 2H9C4 2 2 4 2 9v6c0 3.78 1.14 5.85 3.86 6.62.22-2.6 2.89-4.65 6.14-4.65 3.25 0 5.92 2.05 6.14 4.65C20.86 20.85 22 18.78 22 15V9c0-5-2-7-7-7Zm-3 12.17c-1.98 0-3.58-1.61-3.58-3.59C8.42 8.6 10.02 7 12 7s3.58 1.6 3.58 3.58-1.6 3.59-3.58 3.59Z" />
          <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M15.58 10.58c0 1.98-1.6 3.59-3.58 3.59s-3.58-1.61-3.58-3.59C8.42 8.6 10.02 7 12 7s3.58 1.6 3.58 3.58Z" />
        </svg>

        @if (Agent::isDesktop())
          <div>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}"
              class="w-4 h-4 align-middle transition-transform duration-200 transform md:-mt-1">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
          </div>
        @endif
      </button>

      <div x-cloak x-show="open" x-transition class="absolute right-0 z-30 w-40 shadow-lg top-10 rounded-2xl">
        <div class="flex flex-col items-start justify-between text-gray-700 shadow-lg bg-gray-50 rounded-xl">

          <a href="{{ route('account.profile') }}"
            class="flex items-center justify-start w-full px-4 py-2 space-x-3 text-sm group rounded-t-xl hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring">
            <svg class="w-6 h-6 text-gray-600 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm8.59 10c0-3.87-3.85-7-8.59-7s-8.59 3.13-8.59 7" />
            </svg>
            <span>Профайл</span>
          </a>

          <a href="{{ route('account.orders') }}"
            class="flex items-center justify-start w-full px-4 py-2 space-x-3 text-sm hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring group">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M3.17 7.44 12 12.55l8.77-5.08M12 21.61v-9.07" />
              <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9.93 2.48 4.59 5.45c-1.21.67-2.2 2.35-2.2 3.73v5.65c0 1.38.99 3.06 2.2 3.73l5.34 2.97c1.14.63 3.01.63 4.15 0l5.34-2.97c1.21-.67 2.2-2.35 2.2-3.73V9.18c0-1.38-.99-3.06-2.2-3.73l-5.34-2.97c-1.15-.64-3.01-.64-4.15 0Z" />
              <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 13.24V9.58L7.51 4.1" />
            </svg>
            <span>Заказы</span>
          </a>

          @can('dashboard')
            <a href="{{ route('dashboard.dashboard') }}"
              class="flex items-center justify-start w-full px-4 py-2 space-x-3 text-sm hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring group">

              <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                  stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"
                  d="M10.11 11.15H7.46c-.63 0-1.14.51-1.14 1.14v5.12h3.79v-6.26 0Z" />
                <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                  stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"
                  d="M12.761 6.6h-1.52c-.63 0-1.14.51-1.14 1.14v9.66h3.79V7.74c0-.63-.5-1.14-1.13-1.14zm3.787 6.25h-2.65v4.55h3.79v-3.41c-.01-.63-.52-1.14-1.14-1.14z" />
                <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 22h6c5 0 7-2 7-7V9c0-5-2-7-7-7H9C4 2 2 4 2 9v6c0 5 2 7 7 7Z" />
              </svg>
              <span>Панель</span>
            </a>
          @endcan

          <span class="w-full "></span>
          <a title="выйти" href="{{ route('logout') }}"
            class="flex items-center justify-start w-full px-4 py-2 space-x-3 text-sm rounded-b-xl hover:bg-gray-100 focus:bg-gray-100 focus:outline-none focus:ring group"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <path class="text-gray-600 stroke-current group-hover:text-orange-500 focus:text-orange-500"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M8.9 7.56c.31-3.6 2.16-5.07 6.21-5.07h.13c4.47 0 6.26 1.79 6.26 6.26v6.52c0 4.47-1.79 6.26-6.26 6.26h-.13c-4.02 0-5.87-1.45-6.2-4.99M15 12H3.62m2.23-3.35L2.5 12l3.35 3.35" />
            </svg>

            <span>Выйти</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            {{ csrf_field() }}
          </form>

        </div>
      </div>
    </div>
  @endguest
</div>
