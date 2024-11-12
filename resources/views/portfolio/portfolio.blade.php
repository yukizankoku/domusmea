<x-layouts.main>
<div data-aos="zoom-in" data-aos-duration="1500">
<h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Portfolio</h1>
    
<section class="text-gray-600 body-font">
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
            @if ($portfolio->image && count($portfolio->image) > 0)
                <div>
                    <swiper-container class="mySwiper" navigation="true">
                        @foreach ($portfolio->image as $image)  
                            <swiper-slide><img src="{{ asset('storage/' . $image) }}" class="p-8 max-h-96 rounded-t-lg object-cover" alt="{{ $portfolio->name }}"></swiper-slide>         
                        @endforeach
                    </swiper-container>
                </div>
            @else
                <div>
                    <img src="{{ asset('img/logo.png') }}" class="p-8 rounded-t-lg" alt="...">
                </div>
            @endif
        </div>
      <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">{{ $portfolio->title }}
        </h1>
        <h4 class="mb-8 leading-relaxed">{{ $portfolio->description }}</h4>
        <p>{{ implode(', ', $portfolio->category) }}</p>
        <button class="inline-flex text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded mt-20"><a href="{{ route('portfolio.index') }}">Lihat Portfolio Lainnya</a></button>
      </div>
    </div>
</section>
</div>

{{-- Related Portfolio --}}
<h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Portfolio Lainnya</h1>
<div data-aos="zoom-in" data-aos-duration="1500" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    @forelse ($relatedPortfolios as $related)
    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
        <a href="/portfolios/{{ $related->slug }}">
            @if ($related->image && count($related->image) > 0)
                <div class="swiper-container mySwiper">
                    <swiper-container navigation="true" pagination="true">
                        @foreach ($related->image as $image)  
                            <swiper-slide>
                                <img src="{{ asset('storage/' . $image) }}" class="w-full h-48 object-cover" alt="{{ $related->name }}">
                            </swiper-slide>         
                        @endforeach
                    </swiper-container>
                </div>
            @else
                <div>
                    <img src="{{ asset('img/logo.png') }}" class="w-full h-48 object-cover" alt="...">
                </div>
            @endif
        </a>
        <div class="p-5">
            <a href="/portfolios/{{ $related->slug }}">
                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $related->title }}</h5>
            </a>
            <div class="flex flex-col items-center">
                <span class="text-sm text-gray-700 dark:text-gray-300">{{ implode(', ', $related->category) }}</span>
                <span class="text-gray-900 dark:text-white text-left w-full">{{ Str::limit($related->description, 50, '...') }}</span>
                <a href="/portfolios/{{ $related->slug }}" class="mt-2 text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:ring-yellow-800">Details</a>
            </div>
        </div>
    </div>
    @empty
    <div></div>
        <div>
            <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">No Portfolios Found</h1>
        </div>
    @endforelse
</div>

   
</x-layouts.main>