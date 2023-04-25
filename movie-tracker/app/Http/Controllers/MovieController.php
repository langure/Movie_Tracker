<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
// import the movie model
use App\Models\Movie;

class MovieController extends Controller
{

    public function deleteMovie(Request $request){
        $user_id = auth()->user()->id;

        $tmdb_id = $request->route('id');

        $movie = Movie::where('tmdb_id', $tmdb_id)
                        ->where('user_id', $user_id)
                        ->first();

        
    
        if (!$movie) {
            session()->flash('error', 'Movie not found.');
            return redirect()->back()->withErrors(['Movie not found.']);
        }
    
        $movie->delete();
        session()->flash('success', 'Movie removed successfully.');
        return redirect()->back()->with('success', 'Movie removed successfully.');

    }

    public function listMovies(Request $request){
        // get the signed in user id
        $user_id = auth()->user()->id;

        // get all the movies for the signed in user
        $movies = Movie::where('user_id', $user_id)->get();

        // return the view with the movies
        return view('movie/my-movies', ['movies' => $movies]);
    }

    public function recordMovie(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'movie_id' => 'required|integer',
        ]);

        // Get the movie id from the request
        $movie_id = $request->input('movie_id');

        // get the signed in user id
        $user_id = auth()->user()->id;

        // check if the user has already added the movie
        $existing_movie = Movie::where('tmdb_id', $movie_id)->where('user_id', $user_id)->first();
        if($existing_movie){
            session()->flash('error', 'You have already added this movie!');
            return view('movie/movies');
        }
        
        // try to get the movie details from the TMDB API using the find method and the id
        try {
            // Make an API request using a HTTP client library like Guzzle
            $client = new \GuzzleHttp\Client();
            $url = env('TMDB_FIND_MOVIE_URL').'/'. $movie_id.'?api_key='.env('TMDB_API_KEY');
            $response = $client->request('GET', $url);

            // Get the response body as a string
            $body = $response->getBody()->getContents();
            $data = json_decode($body , true);
            $results = $data;
            
            $movie = new Movie;

            $movie->name = $results['original_title'];
            $movie->year = substr($results['release_date'],0 ,4);
            $movie->director = "N/A";
            $movie->date_watched = date('Y-m-d');
            $movie->rating = 0;
            $movie->running_time_in_minutes = $results['runtime'];
            $movie->description = $results['overview'];
            $movie->image_url = $results['poster_path'];
            $movie->tmdb_id = $results['id'];
            $movie->user_id = $user_id;

            $movie->save();
          
            // Return the response as a view
            session()->flash('success', 'Movie added successfully!');
            return view('movie/movies');
          }// try
          catch(\GuzzleHttp\Exception\GuzzleException $e) {
            // Handle exception
            $error = $e->getMessage();
            session()->flash('error', $error);
            return view('movie/movies');
          }// catch         


    }


    public function searchMovies(Request $request) {
        // Get the search query from the request
        try{
            $validatedData = $request->validate([
                'search-input' => 'required',
            ]);
        }
        catch(\Exception $e){
            $error = $e->getMessage();
            session()->flash('error', "Please enter a search query.");
            return view('movie/movies');
        }

        $query = $request->input('search-input');

      try {
        // Make an API request using a HTTP client library like Guzzle
        $client = new \GuzzleHttp\Client();
        $url = env('TMDB_SEARCH_MOVIES_UTL').'?api_key='.env('TMDB_API_KEY').'&query='.$query.'&page=1&include_adult=true';
        $response = $client->request('GET', $url);
      
        // Get the response body as a string
        $body = $response->getBody()->getContents();
        $data = json_decode($body , true);
        $results = $data['results'];
      
        // Return the response as a view
        return view('movie/results', ['results' => $results, 'secure_base_url' => $this->get_movies_api_base_url()]);
      }// try
      catch(\GuzzleHttp\Exception\GuzzleException $e) {
        // Handle exception
        $error = $e->getMessage();
        session()->flash('error', $error);
        return view('movie/movies');
      }// catch

      }// search movies

      public function get_movies_api_base_url(){
        $secure_base_url = 'secure_base_url';
        if(Cache::has($secure_base_url)){
            return Cache::get($secure_base_url);
        }// if it's in cache
        else{
            try {
                // Make an API request using a HTTP client library like Guzzle
                $client = new \GuzzleHttp\Client();
                $response = $client->request('GET', env('TMDB_CONFIG_URL').'?api_key='.env('TMDB_API_KEY'));
              
                // Get the response body as a string
                $body = $response->getBody()->getContents();
                $data = json_decode($body , true);
                $secure_base_url = $data['images']['secure_base_url'];
                Cache::put($secure_base_url, $secure_base_url, 86400);
                return $secure_base_url;
              }// try
              catch(\GuzzleHttp\Exception\GuzzleException $e) {
                // Handle exception
                $error = $e->getMessage();
                session()->flash('error', $error);
                return view('movie/movies');
              }// catch
        }// else
    }// get_movies_api_base_url

}// class
