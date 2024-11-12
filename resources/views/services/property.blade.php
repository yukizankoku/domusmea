<x-layouts.main>
  <section class="text-gray-600 body-font">
    <div class="container px-5 py-10 mx-auto flex flex-col">
      <div class="w-full mx-auto">
        <div class="rounded-lg overflow-hidden w-full">
          {{-- Property Image --}}
          @if ($property->image && count($property->image) > 0)
            <div>
              {{-- Showing Swiper --}}
              <swiper-container style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="mySwiper" thumbs-swiper=".mySwiper2" loop="true" space-between="10" navigation="true">
                @foreach ($property->image as $image)
                  <swiper-slide><img src="{{ asset('storage/' . $image) }}" class="w-full h-[20rem] sm:h-[28rem] md:h-[36rem] lg:h-[48rem] object-cover rounded-lg" alt="{{ $property->title }}"></swiper-slide>
                @endforeach
              </swiper-container>

              {{-- Thumbs Swiper --}}
              <swiper-container class="mySwiper2" loop="true" navigation="true" space-between="10" slides-per-view="4" free-mode="true" watch-slides-progress="true">
                @foreach ($property->image as $image)
                  <swiper-slide><img src="{{ asset('storage/' . $image) }}" class="w-full h-16 sm:h-20 md:h-24 lg:h-32 object-cover rounded-t-lg" alt="{{ $property->title }}"></swiper-slide>
                @endforeach
              </swiper-container>
            </div>
          @else
            <div>
              <img src="{{ asset('img/logo.png') }}" class="w-full rounded-t-lg" alt="{{ $property->title }}">
            </div>
          @endif
        </div>

        {{-- Property Detail --}}
        <div class="flex flex-col sm:flex-row mt-10">
          <div class="sm:w-2/3 sm:pl-8 sm:py-8 sm:border-l border-gray-200 sm:border-t-0 border-t mt-4 pt-4 text-center sm:text-left">
            <h1 class="flex items-center justify-between w-full p-5 font-large text-gray-700 font-bold border-b border-gray-200 hover:bg-gray-100 gap-3">{{ $property->title }}</h1>
            <h4 class="flex items-center justify-between w-full p-5 font-medium text-gray-500 border-b border-gray-200 hover:bg-gray-100 gap-3">Detail Property</h4>
            
            <!-- Tab Navigation -->
            <div class="flex space-x-4 mb-4 overflow-x-auto">
              <button id="tab1" class="py-2 px-4 text-gray-500 hover:bg-gray-100" onclick="openTab('tab1')">Spesifikasi Bangunan</button>
              <button id="tab2" class="py-2 px-4 text-gray-500 hover:bg-gray-100" onclick="openTab('tab2')">Fasilitas</button>
              <button id="tab3" class="py-2 px-4 text-gray-500 hover:bg-gray-100" onclick="openTab('tab3')">Deskripsi</button>
              <button id="tab4" class="py-2 px-4 text-gray-500 hover:bg-gray-100" onclick="openTab('tab4')">Lokasi</button>
            </div>
            
            <!-- Tab Content -->
            <div id="tab1-content" class="hidden">
              <p class="mb-2 text-gray-500">Luas Tanah: {{ $property->luas_tanah }} m<sup>2</sup></p>
              <p class="mb-2 text-gray-500">Luas Bangunan: {{ $property->luas_bangunan }} m<sup>2</sup></p>
              <p class="mb-2 text-gray-500">Jumlah Lantai: {{ $property->jumlah_lantai }}</p>
            </div>
            
            <div id="tab2-content" class="hidden">
              <p class="mb-2 font-medium text-gray-500">Fasilitas</p>
                @if (!empty($property->amenities))
                  <p class="mb-2 text-gray-500">{!! implode('<br>', $property->amenities) !!}</p>
                @endif
                
                @if (!empty($property->features))
                  <p class="mb-2 text-gray-500">{!! implode('<br>', $property->features) !!}</p>
                @endif
            </div>
            
            <div id="tab3-content" class="hidden">
              <p class="mb-2 text-gray-500">{{ $property->description }}</p>
            </div>
            
            <div id="tab4-content" class="hidden">
              @if ($property->url_map)
                <iframe src="{{ $property->url_map }}" width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>
              @else
                <p class="tracking-tight text-gray-900 text-left">
                  {{ Str::title($property->village->name) }},
                  {{ Str::title($property->district->name) }},
                  {{ Str::title($property->regency->name) }},
                  {{ Str::title($property->province->name) }}</p>
              @endif
            </div>
          </div>
          
          {{-- Sisi Kanan --}}
          <div class="sm:w-1/3 text-center sm:pr-8 sm:py-8">
            <div class="flex flex-col items-center">
              @if ($property->sold)
                <h2 class="font-medium title-font mt-4 text-gray-900 text-lg">Property Sudah Terjual</h2>
              @else
                <h2 class="font-medium title-font mt-4 text-gray-900 text-lg">Harga</h2>
                  <p class="text-3xl font-bold text-gray-900">Rp. {{ number_format($property->price, 0, ',', '.') }}</p>
                  {{-- Whatsapp/Hubungi Kami --}}
                  <div class="w-12 h-1 bg-yellow-500 rounded mt-2 mb-4"></div>
                    <a href="https://wa.me//62{{ substr($company->phone, 1) }}?text={{ urlencode('Hai Admin Domus Mea Saya Tertarik dengan property ini: ' . $property->code . ' - ' . request()->fullUrl()) }}" target="_blank" class="flex items-center text-white bg-yellow-500 py-2 px-6 rounded hover:bg-yellow-600">
                      Negosiasi Sekarang!
                      <svg class="w-6 h-6 ml-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z" />
                      </svg>
                    </a>
                    
                  {{-- Tombol Share --}}
                  <div class="mt-4">
                    <h4 class="font-medium text-gray-500">Bagikan:</h4>
                      <div class="flex space-x-4">
                        {{-- Share Whatsapp --}}
                        <a href="https://wa.me/?text={{ urlencode('Cek properti menarik dari Domus Mea: ' . $property->title . ' - ' . request()->fullUrl()) }}" target="_blank" class="text-white bg-green-500 py-2 px-4 rounded hover:bg-green-600">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.103 1.521 5.879L.052 23.905l5.895-1.48A11.931 11.931 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm.003 21.847a9.838 9.838 0 01-5.31-1.55l-.379-.226-3.497.878.93-3.41-.245-.394A9.834 9.834 0 0112.003 2.16c5.42 0 9.835 4.415 9.835 9.835s-4.415 9.852-9.835 9.852zm5.617-7.413c-.255-.127-1.506-.743-1.74-.828-.234-.085-.405-.127-.575.127-.168.253-.66.828-.808.996-.15.17-.298.191-.552.064-.255-.127-1.078-.398-2.052-1.269-.759-.676-1.271-1.512-1.422-1.766-.149-.255-.016-.391.112-.518.115-.113.255-.296.383-.446.13-.148.171-.253.257-.404.084-.17.042-.319-.02-.446-.063-.127-.554-1.336-.759-1.827-.2-.48-.402-.413-.575-.421-.149-.007-.318-.01-.489-.01-.169 0-.445.064-.68.318-.234.254-.893.875-.893 2.131s.914 2.468 1.04 2.641c.127.169 1.803 2.753 4.37 3.858.611.263 1.088.419 1.459.536.612.195 1.17.168 1.609.102.491-.073 1.506-.615 1.719-1.209.213-.593.213-1.104.149-1.209-.063-.105-.234-.169-.489-.296z" />
                          </svg>
                        </a>
                        {{-- Share URL --}}
                        <button class="text-white bg-gray-500 py-2 px-4 rounded hover:bg-gray-600" onclick="copyToClipboard()" aria-label="Copy Link">
                          <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1V9a4 4 0 0 0-4-4h-3a1.99 1.99 0 0 0-1 .267V5a2 2 0 0 1 2-2h7Z" />
                            <path d="M8 7.054V11H4.2a2 2 0 0 1 .281-.432l2.46-2.87A2 2 0 0 1 8 7.054ZM10 7v4a2 2 0 0 1-2 2H4v6a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3Z" />
                          </svg>
                        </button>
                      </div>
                    </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Related Properties --}}
  <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Mungkin Anda Suka</h1>
  <div data-aos="zoom-in" data-aos-duration="1500" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      @forelse ($relatedProperties as $related)
      <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
          @if ($related->image && count($related->image) > 0)
          <div>
              <swiper-container class="mySwiper" navigation="true">
                  @foreach ($related->image as $image)
                  <swiper-slide>
                      <img src="{{ asset('storage/' . $image) }}" class="w-full h-48 object-cover rounded-t-lg" alt="{{ $related->title }}">
                  </swiper-slide>
                  @endforeach
              </swiper-container>
          </div>
          @else
          <div>
              <img src="{{ asset('img/logo.png') }}" class="w-full h-48 object-cover rounded-t-lg" alt="{{ $related->title }}">
          </div>
          @endif
          <div class="px-5 pb-5">
              <a href="/properties/{{ $related->code }}">
                  <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $related->title }}</h5>
              </a>
              <div class="flex items-center text-gray-800">
                  <img src="{{ asset('img/properties/bedroom.svg') }}" alt="Kamar Tidur" class="w-5 h-5 mr-2">
                  <p class="mr-2">{{ $related->kamar_tidur }}</p>
                  <img src="{{ asset('img/properties/bathroom.svg') }}" alt="Kamar Mandi" class="w-5 h-5 mr-2">
                  <p class="mr-2">{{ $related->kamar_mandi }}</p>
                  <img src="{{ asset('img/properties/carport.svg') }}" alt="Garasi" class="w-5 h-5 mr-2">
                  <p class="mr-2">{{ $related->carport }}</p>
                  <img src="{{ asset('img/properties/house.svg') }}" alt="Luas Bangunan" class="w-5 h-5 mr-2">
                  <p class="mr-2">LB: {{ $related->luas_bangunan }}m<sup>2</sup> / LT: {{ $related->luas_tanah }}m<sup>2</sup></p>
              </div>
              <div>
                  <p class="tracking-tight text-gray-900 dark:text-white text-left">
                      {{ Str::title($related->district->name) }}, {{ Str::title($related->regency->name) }}
                  </p>
              </div>
              <div class="flex items-center justify-between mt-2">
                  <span class="text-3xl font-bold text-gray-900 dark:text-white">Rp. {{ number_format($related->price, 0, ',', '.') }}</span>
              </div>
              <div class="flex justify-center items-center mt-2">
                  <a href="/properties/{{ $related->code }}" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-800">Details</a>
              </div>
          </div>
      </div>
      @empty
        <div></div>
        <div>
          <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5"> Belum ada Property yang tersedia</h1>
        </div>
      @endforelse
    </div>

  <script src="{{ asset('js/shareLink.js') }}"></script>
  <script src="{{ asset('js/tabPropertyDetail.js') }}"></script>
</x-layouts.main>
