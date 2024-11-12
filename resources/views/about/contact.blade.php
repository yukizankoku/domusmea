<x-layouts.main>

    @if(session('success'))
    <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div>
          <span class="font-medium">Success!</span> {{ session('success') }}
        </div>
      </div>
    @endif

    <h1 data-aos="fade-up" data-aos-duration="1500" class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">GET IN TOUCH WITH US</h1>

    {{-- Contact Details --}}
    <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto flex sm:flex-nowrap flex-wrap">
          <div class="lg:w-2/3 md:w-1/2 bg-gray-300 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
            <iframe width="100%" height="100%" class="absolute inset-0" frameborder="0" title="map" marginheight="0" marginwidth="0" scrolling="no" src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d15860.239731055555!2d106.8036792!3d-6.3862672!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sDomus%20Mea%20-%20Tanah%20Baru%20-%20Beji!5e0!3m2!1sid!2sid!4v1726819648967!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="filter: contrast(1.2) opacity(0.7);"></iframe>
            <div class="bg-white relative flex flex-wrap py-6 rounded shadow-md">
              <div class="lg:w-1/2 px-6">
                <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">ADDRESS</h2>
                <p class="mt-1">{{ $company->name }}</p>
                <p class="mt-1">{{ $company->address }}</p>
              </div>
              <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
                <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">EMAIL</h2>
                <a href="mailto:{{ $company->email }}" target="_blank" class="text-indigo-500 leading-relaxed hover:underline">{{ $company->email }}</a>
                <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs mt-4">PHONE</h2>
                <a href="https://wa.me/62{{ substr($company->phone, 1) }}?text=Hai%20Admin%20Domus%20Mea,%20saya%20mau%20tanya%20tanya-tanya%20nih" target="_blank" class="text-indigo-500 leading-relaxed hover:underline">(+62){{ substr($company->phone, 1, 3) }}-{{ substr($company->phone, 4, 4) }}-{{ substr($company->phone, 8) }}</a>
              </div>
            </div>
          </div>

          {{-- Contact Us Form --}}
          <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
            <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Hubungi Kami</h2>
            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="relative mb-4">
                    <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                    @error('name')
                    <p class="text-red-700">{{ $message }}</p>
                    @enderror
                    <input type="text" id="name" name="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out @error('name') is-invalid @enderror" required autofocus value="{{ old('name') }}">
                  </div>
                  <div class="relative mb-4">
                    <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                    @error('email')
                    <p class="text-red-700">{{ $message }}</p>
                    @enderror
                    <input type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out @error('email') is-invalid @enderror" required value="{{ old('email') }}">
                  </div>
                  <div class="relative mb-4">
                    <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                    @error('message')
                    <p class="text-red-700">{{ $message }}</p>
                    @enderror
                    <textarea id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" required></textarea>
                  </div>
                  <button type="submit" class="w-full text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Send</button>
            </form>
          </div>
        </div>
    </section>
    
</x-layouts.main>