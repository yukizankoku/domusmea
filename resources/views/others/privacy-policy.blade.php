<x-layouts.main>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-20 mx-auto">
            <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white mb-10 mt-5">Kebijakan Privasi</h1>
          <div class="xl:w-1/2 lg:w-3/4 w-full mx-auto text-left">
            <p class="leading-relaxed text-lg">
                Tanggal Efektif: {{ \Carbon\Carbon::parse($company->privacy_policy_updated_at)->format('d F Y') }}
            </p>
            <br>
            <p class="leading-relaxed text-lg">{!! $company->privacy_policy !!}</p>
          </div>
        </div>
      </section>
       
</x-layouts.main>