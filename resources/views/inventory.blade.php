<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('new-product') }}">
                        <x-primary-button>Tambah produk</x-primary-button>
                    </a>
                </div>
                <x-bladewind::table exclude_columns="created_at, updated_at" :data="$products" :action_icons="$action_icons" />
            </div>
        </div>
    </div>

    <!-- Include Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2"></script>

    <!-- Your JavaScript code -->
    <script>
        redirect = (url) => {
            window.location.href = url;
        }
    </script>

</x-app-layout>
