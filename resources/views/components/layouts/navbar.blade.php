<nav class="bg-gray-700 border-gray-200 dark:bg-gray-900">
  <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen p-4">
      <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="{{ asset('img/logo.png') }}" class="h-16 pl-7" alt="Flowbite Logo" />
          {{-- <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ $company->name }}</span> --}}
      </a>
      <div class="flex items-center space-x-6 rtl:space-x-reverse">
          <a href="https://wa.me/62{{ substr($company->phone, 1) }}?text=Hai%20Admin%20Domus%20Mea,%20saya%20mau%20tanya%20tanya-tanya%20nih" target="_blank" class="text-md text-yellow-200 dark:text-white hover:text-blue-700">(+62){{ substr($company->phone, 1, 3) }}-{{ substr($company->phone, 4, 4) }}-{{ substr($company->phone, 8) }}</a>
          
            @auth
                @if (!auth()->user()->hasVerifiedEmail())
                <x-auth-session-status class="mb-4 text-white" :status="session('status')" />
                <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg bg-yellow-200 hover:text-white bg-gradient-to-r from-yellow-200 to-gray-700 group dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800" type="button"><span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">{{ Auth::user()->username }}</span>
                </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformationButton">
                        <li>
                            <span class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Your Email is not verified. PLease verify your email</span>
                        </li>
                        <li>
                            <form action="{{ route('verification.send') }}" method="post">
                                @csrf
                                <button type="submit" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Resend Verification Email</button>
                            </form>
                        </li>
                        </ul>
                        <div class="py-2">
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg bg-yellow-200 hover:text-white bg-gradient-to-r from-yellow-200 to-gray-700 group dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800" type="button"><span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">{{ Auth::user()->username }}</span>
                    </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownInformation" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformationButton">
                            <li>
                                <a href="{{ (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin') ? '/admin' : '/user' }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin') ? '/admin/properties' : '/user/properties' }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Property List</a>
                            </li>
                            </ul>
                            <div class="py-2">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</button>
                                </form>
                            </div>
                        </div>
                @endif
            
            @else
                <a href="/login" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg bg-yellow-200 hover:text-white bg-gradient-to-r from-yellow-200 to-gray-700 group dark:text-white focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-800">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                Login
                </span>
                </a>
            @endauth
      </div>
  </div>
</nav>
<nav class="bg-gray-700 dark:bg-gray-700">
  <div class="max-w-screen-xl px-4 py-3 mx-auto">
      <div class="flex items-center">
          <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
              <li>
                  <a href="/properties" class="text-white dark:text-white hover:text-blue-700" aria-current="page">Cari Property</a>
              </li>
              @auth
                    <li>
                    <a href="{{ (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin') ? '/admin/properties/create' : '/user/properties/create' }}" class="text-white dark:text-white hover:text-blue-700">Jual Property</a>
                    </li>
                  @else
                    <li>
                    <a href="/jual-property" class="text-white dark:text-white hover:text-blue-700">Jual Property</a>
                    </li>
              @endauth 
              <li>
                  <a href="/services" class="text-white dark:text-white hover:text-blue-700">Layanan Kami</a>
              </li>
              @auth
                  @else
                  <li>
                    <a href="/join" class="text-white dark:text-white hover:text-blue-700">Bergabung Dengan Kami</a>
                </li>
              @endauth
          </ul>
      </div>
  </div>
</nav>