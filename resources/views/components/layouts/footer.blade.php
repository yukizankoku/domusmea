<footer class="bg-gray-700 border-gray-200 dark:bg-gray-900">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
              <a href="/" class="flex items-center">
                  <img src="{{ asset('img/logo.png') }}" class="h-12 me-3" alt="FlowBite Logo" />
                  {{-- <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ $company->name }}</span> --}}
              </a>
              <p class="mt-4 text-gray-200 dark:text-gray-400">
                {{ $company->name }}
              </p>
              <p class="mt-4 text-gray-200 dark:text-gray-400">
                {{ $company->address }}
              </p>
              <p>
                <a href="https://wa.me/62{{ substr($company->phone, 1) }}?text=Hai%20Admin%20Domus%20Mea,%20saya%20mau%20tanya%20tanya-tanya%20nih" target="_blank" class="mt-4 text-gray-200 dark:text-gray-400">(+62){{ substr($company->phone, 1, 3) }}-{{ substr($company->phone, 4, 4) }}-{{ substr($company->phone, 8) }}</a>
              </p>
              <p>
                <a href="mailto:{{ $company->email }}" target="_blank" class="mt-2 text-gray-200 dark:text-gray-400">{{ $company->email }}</a>
              </p>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-300 uppercase dark:text-white">Tentang</h2>
                  <ul class="text-white dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="/about" class="hover:underline">Tentang Kami</a>
                      </li>
                      <li class="mb-4">
                          <a href="/portfolios" class="hover:underline">Portfolio</a>
                      </li>
                      <li class="mb-4">
                          <a href="/contact" class="hover:underline">Kontak</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-300 uppercase dark:text-white">Layanan Kami</h2>
                  <ul class="text-white dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="/jual-property" class="hover:underline ">Jual Properti</a>
                      </li>
                      <li class="mb-4">
                          <a href="/properties" class="hover:underline ">Cari Properti</a>
                      </li>
                      <li class="mb-4">
                          <a href="/renovasi" class="hover:underline">Renovasi</a>
                      </li>
                      <li class="mb-4">
                          <a href="/furniture" class="hover:underline">Custom Furniture</a>
                      </li>
                  </ul>
              </div>
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-300 uppercase dark:text-white">Others</h2>
                  <ul class="text-white dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="/privacy-policy" class="hover:underline">Privacy Policy</a>
                      </li>
                      <li class="mb-4">
                          <a href="/terms-and-conditions" class="hover:underline">Terms &amp; Conditions</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-white sm:text-center dark:text-gray-400">© 2024 <a href="/" class="hover:underline">Domusmea™</a>. All Rights Reserved.
          </span>
          <div class="flex mt-4 sm:justify-center sm:mt-0">
              <a href="{{ $company->url_facebook }}" class="text-white hover:text-gray-900 dark:hover:text-white">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                        <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                    </svg>
                  <span class="sr-only">Facebook page</span>
              </a>
              <a href="{{ $company->url_instagram }}" class="text-white hover:text-gray-900 dark:hover:text-white ms-5">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path fill="currentColor" fill-rule="evenodd" d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z" clip-rule="evenodd"/>
                  </svg>                  
                  <span class="sr-only">Instagram</span>
              </a>
              <a href="{{ $company->url_youtube }}" class="text-white hover:text-gray-900 dark:hover:text-white ms-5">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z" clip-rule="evenodd"/>
                  </svg>                  
                  <span class="sr-only">Youtube</span>
              </a>
              <a href="{{ $company->url_tiktok }}" class="text-white hover:text-gray-900 dark:hover:text-white ms-5">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path class="cls-1" d="M12.94,1.61V15.78a2.83,2.83,0,0,1-2.83,2.83h0a2.83,2.83,0,0,1-2.83-2.83h0a2.84,2.84,0,0,1,2.83-2.84h0V9.17h0A6.61,6.61,0,0,0,3.5,15.78h0a6.61,6.61,0,0,0,6.61,6.61h0a6.61,6.61,0,0,0,6.61-6.61V9.17l.2.1a8.08,8.08,0,0,0,3.58.84h0V6.33l-.11,0a4.84,4.84,0,0,1-3.67-4.7H12.94Z"/>
                </svg>
                <span class="sr-only">Tiktok</span>
              </a>
              <a href="{{ $company->url_linkedin }}" class="text-white hover:text-gray-900 dark:hover:text-white ms-5">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z" clip-rule="evenodd"/>
                    <path d="M7.2 8.809H4V19.5h3.2V8.809Z"/>
                  </svg>                  
                <span class="sr-only">Linkedin</span>
              </a>
          </div>
      </div>
    </div>
</footer>