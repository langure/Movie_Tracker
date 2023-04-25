<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-white">My movies</h1>
            </div>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($movies as $movie)
                            <div class="flex flex-col border rounded-lg overflow-hidden bg-white">
                                <div class="p-4 flex flex-col flex-grow">
                                    <h2 class="text-black font-bold">{{ $movie->name }}</h2>
                                    <p class="text-gray-500">{{ $movie->year }} - {{ $movie->director }}</p>
                                    <p class="text-gray-500"><B>Date Watched:</B> {{ $movie->date_watched }}</p>
                                    <p class="text-gray-500"><B>Rating:</B> {{ $movie->rating }}</p>
                                    <p class="text-gray-500"><B>Running Time: </B>{{ $movie->running_time_in_minutes }}
                                        min
                                    </p>
                                    <p class="text-gray-600">{{ $movie->description }}</p>
                                    <div class="flex-grow flex">
                                        <form action="{{ route('delete.movie', $movie->tmdb_id) }}" method="POST"
                                            class="flex flex-1 flex-col justify-between">
                                            @csrf
                                            @method('DELETE')
                                            <div></div>
                                            <button type="submit"
                                                class="mt-4 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Remove
                                                Movie</button>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
