<?php

namespace App\Http\Controllers;

use App\User;
use App\Film;
use App\Genre;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use Response;
use App\Repository\Transformers\FilmTransformer;
use \Illuminate\Http\Response as Res;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Input;


class FilmController extends ApiController
{

    /**
     * @var \App\Repository\Transformers\UserTransformer
     * */
    protected $filmTransformer;


    public function __construct(FilmTransformer $filmTransformer)
    {

        $this->filmTransformer = $filmTransformer;

    }

    /**
     * @description: view all Films
     * @param: null
     * @return: Json String response
     */
    public function index(){

       return Film::with('user','comments')
              ->get()
              ->toArray();
    }

    /**
     * @description: view one Films
     * @param: id
     * @return: Json String response
     */
    public function show($id){
        
        $film = Film::with('user')->find($id);

        if(!$film){

            $film = Film::where('slug', $id)->first();
        }
        

        if(count($film) == 0){
            return $this->respondWithError("Film Not Found!");
        }

        return $this->respond([

            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Record Found',
            'Film' => $this->filmTransformer->transform($film)
        ]);
        

    }

    /**
     * @description: create an Film
     * @param: api form data
     * @return: Json String response
     */
    public function store(Request $request){
        \DB::enableQueryLog();
        $rules = array (
            'name' => 'required',
            'description' => 'required',
            'release_date' => 'required',
            'rating' => 'integer|required',
            'ticket_price' => 'required',
            'country' => 'required',
            'photo' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator-> fails()){

            return $this->respondValidationError('Fields Validation Failed.', $validator->errors());

        }

       $api_token = $request['access_token'];
       $slug      = $this->getSlug($request['name']);

       $film_genre_ids = [];

       if(!empty($request['geners'])) {
           $film_genre_ids = $this->getGenreIdList($request['geners']);
       }

        try{
            $user = JWTAuth::toUser($api_token);
            $film = new Film();
            $film->user_id = $user->id;
            $film->name = $request['name'];
            $film->slug = $slug;
            $film->description = $request['description'];
            $film->release_date = $request['release_date'];
            $film->rating = $request['rating'];
            $film->ticket_price = $request['ticket_price'];
            $film->country = $request['country'];
            $film->photo = $request['photo'];
            $film->save();

            //saving/updating the related Genres in the fashion of many to many relationship
            $film->genres()->sync($film_genre_ids);
            return $this->respondCreated('Film created successfully!', 
            	   $this->filmTransformer->transform($film));

        }catch(JWTException $e){

            return $this->respondInternalError($e->getMessage());

            return $this->respondInternalError("An error occurred while performing an action!");

        }

    }

    /*
    Get Film genres by Query
    */
    public function getGenres($query){

        return  Genre::select('display_name as text')
                ->where('display_name', $query)
                ->orWhere('name', 'like', '%' . $query . '%')->get()
                ->toArray();

    }

    /*
     * Get slug value
     */
     public function getSlug($filmName) {

         $slug  = str_slug($filmName , "-");
         // check to see if any other slugs exist that are the same & count them
         $count = Film::whereRaw("slug LIKE '^{$slug}(-[0-9]+)?$'")->count();
         //$laQuery = \DB::getQueryLog();
         //return $laQuery;
         // if other slugs exist that are the same, append the count to the slug
         return $slug = $count ? "{$slug}-{$count}" : $slug;
     }

     /*
      * Get genre list, insert if not exist.
      * */
      public function getGenreIdList($input_film_genres) {
          $film_genre_ids = [];
          if($input_film_genres){
             foreach ($input_film_genres AS $film_genre){
                  //if geners dose not exist in table, add it.
                  //$gener_search = Genre::Where('name', $film_genre[1]);
                  $existing_film_genre = Genre::whereRaw("name = '$film_genre'")->get()->first();
                  if(count($existing_film_genre)){
                      $film_genre_ids[] = $existing_film_genre->id;
                  }else
                  {
                      $film_genre = Genre::create(['name' => strtolower($film_genre), 'display_name' => $film_genre]);
                      $film_genre_ids[] = $film_genre->id;
                  }
              }

              return $film_genre_ids;
          }
      }
    
}
