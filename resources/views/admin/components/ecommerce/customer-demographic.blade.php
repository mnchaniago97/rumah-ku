@props(['countries' => []])

@php
    $defaultCountries = [
        [
            'name' => 'USA',
            'flag' => '/assets/admin/images/country/country-01.svg',
            'customers' => '2,379',
            'percentage' => 79
        ],
        [
            'name' => 'France',
            'flag' => '/assets/admin/images/country/country-02.svg',
            'customers' => '589',
            'percentage' => 23
        ],
    ];
    
    $countriesList = !empty($countries) ? $countries : $defaultCountries;
@endphp

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Sebaran Kota
            </h3>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                Jumlah properti berdasarkan kota (hanya yang terbit & disetujui).
            </p>
        </div>

         <!-- Dropdown Menu -->
         <x-common.dropdown-menu />
         <!-- End Dropdown Menu -->
    </div>

    <div class="border-gary-200 my-6 overflow-hidden rounded-2xl border bg-gray-50 px-4 py-6 dark:border-gray-800 dark:bg-gray-900 sm:px-6">
        <div id="mapOne" class="mapOne map-btn -mx-4 -my-6 h-[212px] w-[252px] 2xsm:w-[307px] xsm:w-[358px] sm:-mx-6 md:w-[668px] lg:w-[634px] xl:w-[393px] 2xl:w-[554px]"></div>
    </div>

    <div class="space-y-5">
        @foreach($countriesList as $country)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22s7-4.5 7-12a7 7 0 1 0-14 0c0 7.5 7 12 7 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                            {{ $country['name'] }}
                        </p>
                        <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $country['customers'] }} {{ $country['label'] ?? 'Properti' }}
                        </span>
                    </div>
                </div>

                <div class="flex w-full max-w-[140px] items-center gap-3">
                    <div class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800">
                        <div 
                            class="absolute left-0 top-0 flex h-full items-center justify-center rounded-sm bg-brand-500 text-xs font-medium text-white"
                            style="width: {{ $country['percentage'] }}%"
                        ></div>
                    </div>
                    <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                        {{ $country['percentage'] }}%
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
