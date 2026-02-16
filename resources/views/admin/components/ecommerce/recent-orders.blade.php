@props(['products' => []])

@php
    $productsList = $products;
@endphp

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6" x-data="{ filterOpen: false, selectedStatus: '' }">
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Properti Terbaru</h3>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative">
                <button @click="filterOpen = !filterOpen" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" fill="" stroke="" stroke-width="1.5" />
                        <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" fill="" stroke="" stroke-width="1.5" />
                    </svg>
                    Filter
                </button>
                
                <div x-show="filterOpen" @click.away="filterOpen = false" x-transition class="absolute right-0 mt-2 w-48 rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800 z-10">
                    <div class="p-2">
                        <p class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400">Filter Status</p>
                        <button @click="selectedStatus = ''; filterOpen = false" class="w-full px-3 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded" :class="{ 'bg-gray-100 dark:bg-gray-700': selectedStatus === '' }">Semua</button>
                        <button @click="selectedStatus = 'Published'; filterOpen = false" class="w-full px-3 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded" :class="{ 'bg-gray-100 dark:bg-gray-700': selectedStatus === 'Published' }">Published</button>
                        <button @click="selectedStatus = 'Pending Approval'; filterOpen = false" class="w-full px-3 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded" :class="{ 'bg-gray-100 dark:bg-gray-700': selectedStatus === 'Pending Approval' }">Pending Approval</button>
                        <button @click="selectedStatus = 'Draft'; filterOpen = false" class="w-full px-3 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded" :class="{ 'bg-gray-100 dark:bg-gray-700': selectedStatus === 'Draft' }">Draft</button>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.properties.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                Lihat Semua
            </a>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <thead>
                <tr class="border-t border-gray-100 dark:border-gray-800">
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Properti</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kategori</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Harga</p>
                    </th>
                    <th class="py-3 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($productsList))
                    <template x-for="(product, index) in {{ json_encode($productsList) }}.filter(p => !selectedStatus || p.status === selectedStatus)" :key="index">
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <td class="py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-[50px] w-[50px] overflow-hidden rounded-md">
                                        <img :src="product.image" :alt="product.name" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90" x-text="product.name"></p>
                                        <span class="text-gray-500 text-theme-xs dark:text-gray-400" x-text="product.variants"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400" x-text="product.category"></p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <p class="text-gray-500 text-theme-sm dark:text-gray-400" x-text="product.price"></p>
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                <span :class="{
                                    'rounded-full px-2 py-0.5 text-theme-xs font-medium': true,
                                    'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500': product.status === 'Published',
                                    'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400': product.status === 'Pending Approval',
                                    'bg-gray-50 text-gray-600 dark:bg-gray-500/15 dark:text-gray-400': product.status === 'Draft'
                                }" x-text="product.status"></span>
                            </td>
                        </tr>
                    </template>
                @else
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <td colspan="4" class="py-8 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fa fa-home text-3xl text-gray-300"></i>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada properti</p>
                            </div>
                        </td>
                    </tr>
                @endif
                <tr x-show="{{ !empty($productsList) ? 'true' : 'false' }} && {{ json_encode($productsList) }}.filter(p => !selectedStatus || p.status === selectedStatus).length === 0" class="border-t border-gray-100 dark:border-gray-800">
                    <td colspan="4" class="py-8 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fa fa-home text-3xl text-gray-300"></i>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada properti yang sesuai filter</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
