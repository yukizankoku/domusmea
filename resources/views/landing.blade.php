<x-layouts.main>

    {{-- Promoted Property --}}
    <!-- Slider main container -->
    <div data-aos="zoom-in" data-aos-duration="1500" class="swiperCarousel">
        <swiper-container pagination="true" pagination-clickable="true" navigation="true" space-between="30"
            centered-slides="true" autoplay-delay="2500" autoplay-disable-on-interaction="false">

            <!-- Items -->
            @foreach ($carousels as $carousel)
                <swiper-slide class="relative">
                    @if ($carousel->image)
                        <div>
                            <img src="{{ asset('storage/' . $carousel->image[0]) }}"
                                class="absolute inset-0 w-full h-full object-cover" alt="{{ $carousel->title }}">
                        </div>
                    @else
                        <div>
                            <img src="{{ asset('img/logo.png') }}"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="{{ $carousel->title }}">
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 p-5 bg-gray-500 bg-opacity-75 text-white">
                        <a href="/properties/{{ $carousel->code }}">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight">{{ $carousel->title }}</h5>
                            <p class="mb-3 font-normal">Rp. {{ number_format($carousel->price, 0, ',', '.') }}</p>
                        </a>
                        <a href="/properties/{{ $carousel->code }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-500 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            Details
                        </a>
                    </div>
                </swiper-slide>
            @endforeach
        </swiper-container>
    </div>

    {{-- Daftar Property --}}
    <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="30"
    breakpoints='{
        "640": {
            "slidesPerView": 1
        },
        "768": {
            "slidesPerView": 2
        },
        "1024": {
            "slidesPerView": 3
        }
    }'>
        @foreach ($properties as $property)
            <swiper-slide>
                <div data-aos="zoom-in" data-aos-duration="1500" class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-10 flex flex-col min-h-[500px]">
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
                    <div class="px-5 pb-5 flex-grow">
                        <a href="/properties/{{ $property->code }}">
                            <h5 class="font-semibold tracking-tight text-gray-900 dark:text-white text-left">
                                {{ $property->title }}
                            </h5>
                        </a>
                        <div class="flex justify-left items-left text-gray-800">
                            <img src="{{ asset('img/properties/bedroom.svg') }}" alt="Kamar Tidur" class="w-5 h-5 mr-2">
                            <p class="mr-2">{{ $property->kamar_tidur }}</p>
                            <img src="{{ asset('img/properties/bathroom.svg') }}" alt="Kamar Mandi" class="w-5 h-5 mr-2">
                            <p class="mr-2">{{ $property->kamar_mandi }}</p>
                            <img src="{{ asset('img/properties/carport.svg') }}" alt="Garasi" class="w-5 h-5 mr-2">
                            <p class="mr-2">{{ $property->carport }}</p>
                            <img src="{{ asset('img/properties/house.svg') }}" alt="Garasi" class="w-5 h-5 mr-2">
                            <p class="mr-2 text-sm">LB: {{ $property->luas_bangunan }}m<sup>2</sup> / LT: {{ $property->luas_tanah }}m<sup>2</p>
                        </div>
                        <div>
                            <p class="tracking-tight text-gray-900 dark:text-white text-left">
                                {{ Str::title($property->district->name) }},
                                {{ Str::title($property->regency->name) }}
                            </p>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">Rp.
                                {{ number_format($property->price, 0, ',', '.') }}</span>
                            <a href="/properties/{{ $property->code }}"
                                class="mt-2 text-white bg-yellow-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:ring-blue-800">Details</a>
                            <div class="swipe-indicator md:hidden text-center text-gray-500 text-sm my-2">
                                Swipe for more →
                            </div>
                        </div>
                    </div>
                </div>
            </swiper-slide>
        @endforeach
    </swiper-container>

    <div class="display flex justify-center mt-6 mb-10">
        <a href="/properties" class="inline-flex items-center text-white bg-yellow-500 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900">
            Lihat Lebih Banyak
        </a>
    </div>

    {{-- Services --}}
    <div data-aos="fade-up" data-aos-duration="1500" id="service">
        <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">
            Layanan Kami
        </h1>
        <div data-aos="flip-right" data-aos-duration="1500"><x-renovasi /></div>

        <div data-aos="flip-left" data-aos-duration="1500"><x-furniture /></div>
    </div>

    {{-- Portfolios --}}
    <div data-aos="fade-up" data-aos-duration="1500" id="portfolios">
        <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Portfolio
        </h1>
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="30"
        breakpoints='{
            "640": {
                "slidesPerView": 1
            },
            "768": {
                "slidesPerView": 2
            },
            "1024": {
                "slidesPerView": 3
            }
        }'>
            @foreach ($portfolios as $portfolio)
                <swiper-slide>
                    <div class="w-full max-w-sm min-h-[400px] bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-10 flex flex-col">
                        @if ($portfolio->image && count($portfolio->image) > 0)
                            <div>
                                <swiper-container class="mySwiper" navigation="true">
                                    @foreach ($portfolio->image as $image)
                                        <swiper-slide><img src="{{ asset('storage/' . $image) }}" class="w-full h-72 object-cover rounded-t-lg" alt="{{ $portfolio->name }}"></swiper-slide>
                                    @endforeach
                                </swiper-container>
                            </div>
                        @else
                            <div>
                                <img src="{{ asset('img/logo.png') }}" class="w-full h-72 object-cover rounded-t-lg" alt="...">
                            </div>
                        @endif
                        <div class="px-5 pb-5 flex-grow">
                            <a href="/portfolios/{{ $portfolio->slug }}">
                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white text-left mb-3">
                                    {{ $portfolio->title }}
                                </h5>
                            </a>
                            <div class="flex flex-col items-center">
                                <span
                                    class="text-sm sm:text-base font-bold">{{ implode(', ', $portfolio->category) }}
                                </span>
                                <span
                                    class="text-gray-900 dark:text-white text-left w-full">{{ Str::limit($portfolio->description, 50, '...') }}
                                </span>
                                <a href="/portfolios/{{ $portfolio->slug }}"
                                    class="mt-2 text-white bg-yellow-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:focus:ring-blue-800">Details</a>
                                <div class="swipe-indicator md:hidden text-center text-gray-500 text-sm my-2">
                                    Swipe for more →
                                </div>
                            </div>
                        </div>
                    </div>
                </swiper-slide>
            @endforeach
        </swiper-container>
    </div>

    <div class="display flex justify-center mt-6 mb-10">
        <a href="/portfolios" class="inline-flex items-center text-white bg-yellow-500 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900">Lihat Lebih Banyak</a>
    </div>

    {{-- Testimonial --}}
    <div data-aos="fade-up" data-aos-duration="1500" id="testimoni">
        <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Testimoni
        </h1>
        <swiper-container class="mySwiper" loop="true" space-between="30" centered-slides="true"
        breakpoints='{
            "640": {
                "slidesPerView": 2
            },
            "768": {
                "slidesPerView": 3
            },
            "1024": {
                "slidesPerView": 4
            }
        }'>
            @foreach ($testimonies as $testimony)
                <swiper-slide>
                    <div
                        class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-5 flex flex-col">
                        <div class="flex flex-col items-center pb-10">
                            @if ($testimony->image)
                                <div>
                                    <img src="{{ asset('storage/' . $testimony->image) }}" class="w-full h-72 object-cover rounded-full" alt="{{ $testimony->client }}">
                                </div>
                            @else
                                <div>
                                    <img src="{{ asset('img/logo.png') }}" class="w-full h-72 object-cover rounded-full" alt="...">
                                </div>
                            @endif
                            <div class="flex mt-4 md:mt-6">
                                <p class="mb-1 text-xl text-gray-900 dark:text-white">"{{ $testimony->testimony }}"
                                </p>
                            </div>
                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                -{{ $testimony->client }}-</h5>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Service :
                                {{ implode(', ', $testimony->category) }}</span>
                        </div>
                        <div class="swipe-indicator md:hidden text-center text-gray-500 text-sm my-2">
                            Swipe for more →
                        </div>
                    </div>
                </swiper-slide>
            @endforeach
        </swiper-container>
    </div>

    <a href="https://wa.me/62{{ substr($company->phone, 1) }}?text=Hai%20Admin%20Domus%20Mea,%20saya%20mau%20tanya%20tanya-tanya%20nih"
        target="_blank" id="whatsappBtn"
        class="fixed bottom-20 right-5 bg-green-500 text-white py-3 px-4 rounded-full flex items-center shadow-lg hover:bg-green-600 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.103 1.521 5.879L.052 23.905l5.895-1.48A11.931 11.931 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm.003 21.847a9.838 9.838 0 01-5.31-1.55l-.379-.226-3.497.878.93-3.41-.245-.394A9.834 9.834 0 0112.003 2.16c5.42 0 9.835 4.415 9.835 9.835s-4.415 9.852-9.835 9.852zm5.617-7.413c-.255-.127-1.506-.743-1.74-.828-.234-.085-.405-.127-.575.127-.168.253-.66.828-.808.996-.15.17-.298.191-.552.064-.255-.127-1.078-.398-2.052-1.269-.759-.676-1.271-1.512-1.422-1.766-.149-.255-.016-.391.112-.518.115-.113.255-.296.383-.446.13-.148.171-.253.257-.404.084-.17.042-.319-.02-.446-.063-.127-.554-1.336-.759-1.827-.2-.48-.402-.413-.575-.421-.149-.007-.318-.01-.489-.01-.169 0-.445.064-.68.318-.234.254-.893.875-.893 2.131s.914 2.468 1.04 2.641c.127.169 1.803 2.753 4.37 3.858.611.263 1.088.419 1.459.536.612.195 1.17.168 1.609.102.491-.073 1.506-.615 1.719-1.209.213-.593.213-1.104.149-1.209-.063-.105-.234-.169-.489-.296z" />
        </svg>
        Hubungi Kami
    </a>

</x-layouts.main>
