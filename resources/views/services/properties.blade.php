<x-layouts.main>

    <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Cari Property</h1>

    {{-- Search Form, Button Drawer --}}
    <div class="max-w-md mx-auto flex items-center space-x-4 mb-1"> 
        {{-- Search Form --}}
        <form class="flex-grow" action="{{ route('property.index') }}" method="GET">   
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari Property</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari berdasarkan lokasi" value="{{ request('search') }}" />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
            </div>
        </form>
    </div>

    {{-- Button Drawer --}}
    <div class="border-b border-gray-300 rounded-lg mb-5">
    <div class="max-w-md mx-auto flex items-center space-x-4">
    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button" data-drawer-target="drawer-example" data-drawer-show="drawer-example" aria-controls="drawer-example">
        <img src="{{ asset('img/icons/filter.svg') }}" alt="filter" class="w-4 h-4 inline">
        Filter
    </button>
    </div>
    </div>
    
     
     <!-- Drawer Component -->
     <div id="drawer-example" class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-label">
        <h5 id="drawer-label" class="mb-4 text-base font-semibold text-gray-700 dark:text-gray-300">Pencarian Lanjutan</h5>
        <button type="button" data-drawer-hide="drawer-example" aria-controls="drawer-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 right-2.5 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Tutup</span>
        </button>
        
        <div class="mt-4">
            <form action="{{ route('property.index') }}" method="GET" class="space-y-4">
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Sort By Dropdown --}}
                <div>
                    <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan:</label>
                    <select name="sort_by" id="sort_by" onchange="this.form.submit()" 
                        class="border border-gray-300 p-2 w-full rounded-md bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="">Urutkan</option>
                        <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Harga (Termurah)</option>
                        <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Harga (Termahal)</option>
                        <option value="luas_asc" {{ request('sort_by') == 'luas_asc' ? 'selected' : '' }}>Luas (Terkecil)</option>
                        <option value="luas_desc" {{ request('sort_by') == 'luas_desc' ? 'selected' : '' }}>Luas (Terbesar)</option>
                    </select>
                </div>

                {{-- Filter by Type --}}
                <div>
                    <label for="propertyType" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe:</label>
                    <select name="propertyType" id="propertyType" onchange="this.form.submit()" 
                        class="border border-gray-300 p-2 w-full rounded-md bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="">Semua</option>
                        <option value="Jual" {{ request('propertyType') == 'Jual' ? 'selected' : '' }}>Jual</option>
                        <option value="Sewa" {{ request('propertyType') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                    </select>
                </div>

                {{-- Filter by Category --}}
                <div>
                    <label for="propertyCategory" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori:</label>
                    <select name="propertyCategory" id="propertyCategory" onchange="this.form.submit()" 
                        class="border border-gray-300 p-2 w-full rounded-md bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        <option value="">Semua</option>
                        <option value="Rumah" {{ request('propertyCategory') == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                        <option value="Apartement" {{ request('propertyCategory') == 'Apartement' ? 'selected' : '' }}>Apartement</option>
                        <option value="Villa" {{ request('propertyCategory') == 'Villa' ? 'selected' : '' }}>Villa</option>
                        <option value="Kantor" {{ request('propertyCategory') == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                        <option value="Tanah" {{ request('propertyCategory') == 'Tanah' ? 'selected' : '' }}>Tanah</option>
                    </select>
                </div>

                {{-- Filter by Area --}}
                <div>
                    <label for="area" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi:</label>
                    <input type="text" name="area" id="area" class="border p-2 mb-4 w-full rounded-md" placeholder="Masukkan lokasi" value="{{ request('area') }}" autofocus/>
                </div>

                {{-- Filter by Price --}}
                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Minimum:</label>
                    <div class="flex items-center mb-2">
                        <input type="number" name="min_price_input" class="border p-2 mb-4 w-full rounded-md" min="0" step="1000000" placeholder="Masukan Harga Minimum" value="{{ request('min_price') }}">
                    </div>
                </div>
                
                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Maksimum:</label>
                    <div class="flex items-center mb-2">
                        <input type="number" name="max_price_input" class="border p-2 mb-4 w-full rounded-md" min="0" step="1000000" placeholder="Masukan Harga Maksimum" value="{{ request('max_price') }}">
                    </div>
                </div>
    
                {{-- Filter by Luas Tanah --}}
                <div>
                    <label for="min_luas_tanah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Tanah Min:</label>
                    <input type="number" min="0" step="10" name="min_luas_tanah" id="min_luas_tanah" class="border p-2 mb-4 w-full rounded-md" placeholder="Masukkan luas tanah minimum" value="{{ request('min_luas_tanah') }}">
                </div>
    
                <div>
                    <label for="max_luas_tanah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Tanah Max:</label>
                    <input type="number" min="0" step="10" name="max_luas_tanah" id="max_luas_tanah" class="border p-2 mb-4 w-full rounded-md" placeholder="Masukkan luas tanah maksimum" value="{{ request('max_luas_tanah') }}">
                </div>
    
                {{-- Filter by Luas Bangunan --}}
                <div>
                    <label for="min_luas_bangunan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Bangunan Min:</label>
                    <input type="number" min="0" step="10" name="min_luas_bangunan" id="min_luas_bangunan" class="border p-2 mb-4 w-full rounded-md" placeholder="Masukkan luas bangunan minimum" value="{{ request('min_luas_bangunan') }}">
                </div>
    
                <div>
                    <label for="max_luas_bangunan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Bangunan Max:</label>
                    <input type="number" min="0" step="10" name="max_luas_bangunan" id="max_luas_bangunan" class="border p-2 mb-4 w-full rounded-md" placeholder="Masukkan luas bangunan maksimum" value="{{ request('max_luas_bangunan') }}">
                </div>
                
                {{-- Submit and Reset Button --}}
                <a href="/properties" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-150 inline-block text-center">Reset</a>
                <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-150">Terapkan Filter</button>
            </form>
        </div>
    </div>
    
        

    {{-- Properties List --}}
    <div data-aos="zoom-in" data-aos-duration="1500" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-5 px-4">
        @forelse ($properties as $property)
        <div class="w-full max-w-sm mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            @if ($property->image && count($property->image) > 0)
                <div>
                    <swiper-container class="mySwiper" navigation="true">
                        @foreach ($property->image as $image)
                            <swiper-slide><img src="{{ asset('storage/' . $image) }}" class="w-full h-72 object-cover rounded-t-lg" alt="{{ $property->title }}"></swiper-slide>
                        @endforeach
                    </swiper-container>
                </div>
            @else
                <div>
                    <img src="{{ asset('img/logo.png') }}" class="w-full h-72 object-cover rounded-t-lg" alt="{{ $property->title }}">
                </div>
            @endif
            <div class="px-4 py-4 sm:px-5 sm:pb-5">
                <a href="/properties/{{ $property->code }}">
                    <h5 class="text-s tracking-tight text-gray-900 dark:text-white">{{ $property->type }}, {{ $property->category }}</h5>
                    <h5 class="text-lg sm:text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $property->title }}</h5>
                </a>
                <div class="flex flex-wrap items-center text-gray-800 mt-2">
                    <img src="{{ asset('img/properties/bedroom.svg') }}" alt="Kamar Tidur" class="w-5 h-5 mr-2">
                    <p class="mr-2">{{ $property->kamar_tidur }}</p>
                    <img src="{{ asset('img/properties/bathroom.svg') }}" alt="Kamar Mandi" class="w-5 h-5 mr-2">
                    <p class="mr-2">{{ $property->kamar_mandi }}</p>
                    <img src="{{ asset('img/properties/carport.svg') }}" alt="Garasi" class="w-5 h-5 mr-2">
                    <p class="mr-2">{{ $property->carport }}</p>
                    <img src="{{ asset('img/properties/house.svg') }}" alt="Garasi" class="w-5 h-5 mr-2">
                    <p class="mr-2">LB: {{ $property->luas_bangunan }}m<sup>2</sup> / LT: {{ $property->luas_tanah }}m<sup>2</sup></p>
                </div>
                <div>
                    <p class="tracking-tight text-gray-900 dark:text-white text-left">{{ Str::title($property->district->name) }}, {{ Str::title($property->regency->name) }}</p>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Rp. {{ number_format($property->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-center items-center mt-2">
                    <a href="/properties/{{ $property->code }}" class="text-white bg-yellow-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-blue-800">Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Data Not Found</h1>
        </div>
        @endforelse
    </div>    

   {{ $properties->appends(request()->query())->links('components.pagination') }}

    {{-- Script public/js/propertyFilter.js --}}
   <script src="{{ asset('js/propertyFilter.js') }}"></script>

</x-layouts.main>