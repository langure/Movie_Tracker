<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-white">Movie Search - Results</h1>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full flex flex-wrap items-center justify-center lg:justify-end">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($results as $result)
                                <div class="max-w-xs rounded overflow-hidden shadow-lg bg-white">
                                    <img class="w-full h-48 object-cover"
                                        src="{{ $secure_base_url . 'w200' . $result['poster_path'] }}"
                                        alt="{{ $result['original_title'] }}">
                                    <div class="px-6 py-4">
                                        <div class="font-bold text-xl mb-2 text-black">{{ $result['title'] }}</div>
                                        <p class="text-gray-700 text-base">
                                            {{ strlen($result['overview']) > 200 ? substr($result['overview'], 0, 200) . '...' : $result['overview'] }}
                                        </p>

                                        <p class="text-gray-700 text-base"><B>Year:</B> {{ $result['release_date'] }}
                                        </p>
                                        <p class="text-gray-700 text-base"><B>Popularity:</B>
                                            {{ $result['popularity'] }}</p>
                                        <p class="text-gray-700 text-base"><B>Vote Count:</B>
                                            {{ $result['vote_count'] }}</p>
                                        <form action="{{ route('record.movie') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="movie_id" value="{{ $result['id'] }}">
                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">I
                                                watched it</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
