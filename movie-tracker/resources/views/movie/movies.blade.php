<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if (session()->has('error'))
                    <div class="bg-red-500 text-white py-2 px-4 rounded-lg">
                        <p>{{ session('error') }}</p>
                    </div>
                    {{ session()->forget('error') }}
                @endif
                @if (session()->has('success'))
                    <div class="bg-green-500 text-white py-2 px-4 rounded-lg">
                        <p>{{ session('success') }}</p>
                    </div>
                    {{ session()->forget('success') }}
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="w-full flex flex-wrap items-center justify-center lg:justify-end">
                        <form action="{{ route('search.movies') }}" method="POST" class="w-full lg:w-full">
                            @csrf
                            <input type="text" name="search-input" id="search-input"
                                placeholder="Search movies by title"
                                class="w-full lg:w-full px-4 py-2 border border-gray-300 rounded-md text-black">
                            <button type="submit"
                                class="float-right px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-md mt-4 w-full lg:w-auto ml-auto "
                                id="search-button">Search</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
