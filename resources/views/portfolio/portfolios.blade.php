<x-layouts.main>

    <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Portfolios</h1>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('portfolio.index') }}" class="max-w-lg mx-auto">
        <div>
            <select name="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">All Categories</option>
                <option value="Renovasi" {{ request('category') == 'Renovasi' ? 'selected' : '' }}>Renovasi</option>
                <option value="Furniture" {{ request('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                <option value="Bangun Baru" {{ request('category') == 'Bangun Baru' ? 'selected' : '' }}>Bangun Baru</option>
                <option value="Interior" {{ request('category') == 'Interior' ? 'selected' : '' }}>Interior</option>
                <option value="Exterior" {{ request('category') == 'Exterior' ? 'selected' : '' }}>Exterior</option>
            </select>

            <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari..." />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cari</button>
            </div>
        </div>
    </form>
        

    {{-- Portfolios List --}}
    <div data-aos="zoom-in" data-aos-duration="1500" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-5">
        @forelse ($portfolios as $portfolio )
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            @if ($portfolio->image && count($portfolio->image) > 0)
                <div>
                    <swiper-container class="mySwiper" navigation="true">
                        @foreach ($portfolio->image as $image)  
                            <swiper-slide>
                                <img src="{{ asset('storage/' . $image) }}" class="w-full h-72 object-cover rounded-t-lg" alt="{{ $portfolio->name }}">
                            </swiper-slide>         
                        @endforeach
                    </swiper-container>
                </div>
            @else
                <div>
                    <img src="{{ asset('img/logo.png') }}" class="w-full h-72 object-cover rounded-t-lg" alt="...">
                </div>
            @endif
            <div class="p-5">
                <a href="/portfolios/{{ $portfolio->slug }}">
                    <h5 class="mb-2 text-xl sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $portfolio->title }}</h5>
                </a>
                <div class="flex flex-col items-center">
                    <span class="text-sm sm:text-base font-bold">{{ implode(', ', $portfolio->category) }}</span>
                    <span class="text-gray-900 dark:text-white text-left w-full text-sm sm:text-base">{{ Str::limit($portfolio->description, 50, '...') }}</span>
                    <a href="/portfolios/{{ $portfolio->slug }}" class="mt-2 text-white bg-yellow-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:ring-blue-800">Details</a>
                </div>
            </div>
        </div>
        @empty
        <div></div>
            <div class="col-span-1 md:col-span-3 lg:col-span-4">
                <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">No Portfolios Found</h1>
            </div>
        @endforelse
    </div>
    
   {{ $portfolios->appends(request()->query())->links('components.pagination') }}
</x-layouts.main>