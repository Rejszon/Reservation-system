<nav class="bg-white dark:bg-gray-900 w-full z-20 border-b border-gray-200 dark:border-gray-600">
  <div class="w-full flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Logo">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
    </a>
    <div class="items-center hidden w-full md:flex md:w-auto" id="navbar-sticky">
      <ul class="flex flex-row items-center space-x-4 text-gray-900 font-medium dark:text-white">
        <li>
          <a href="{{route('home')}}" class="{{$activePage == 'home' ? 'text-blue-500' : 'hover:text-blue-500'}} py-2 px-3">Strona główna</a>
        </li>
        <li>
          <a href="{{route('services')}}" class="{{$activePage == 'services' ? 'text-blue-500' : 'hover:text-blue-500'}} py-2 px-3">Usługi</a>
        </li>
        <li>
          <a href="{{route('contact')}}" class="{{$activePage == 'contact' ? 'text-blue-500' : 'hover:text-blue-500'}} py-2 px-3">Kontakt</a>
        </li>
      </ul>
    </div>
    <div>
      <ul class="text-gray-900 font-medium dark:text-white">
        <li class="relative">
          <a href="{{route('login.form')}}">
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" 
              class="flex items-center py-2 px-3 hover:text-blue-700 dark:hover:text-blue-500">
              Zaloguj się
              <svg class="w-2.5 h-2.5 ms-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" aria-hidden="true">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l4 4 4-4"/>
              </svg>
            </button>
          </a>
          <div id="dropdownNavbar" class="z-10 hidden absolute mt-2 bg-white rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Dashboard</a>
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Earnings</a>
              </li>
            </ul>
            <div class="py-1">
              <a href="{{route('login.signout')}}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Wyloguj się</a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
