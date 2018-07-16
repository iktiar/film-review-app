<?php

namespace App\Http\Controllers;

use App\User;
use App\Film;
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

       return Film::with('user')
              ->get()
              ->toArray();


        $limit = Input::get('limit') ?: 3;

        $films = Film::with('user')->paginate($limit);
        


        return $this->respondWithPagination($films, [
            'films' => $this->filmTransformer->transformCollection($films->all())
        ], 'Records Found!');
        
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

        $rules = array (

            'api_token' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:films',
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

        $api_token = $request['api_token'];

        try{

            $user = JWTAuth::toUser($api_token);

            $film = new Film();
            $film->user_id = $user->id;
            $film->name = $request['name'];
            $film->slug = $request['slug'];
            $film->description = $request['description'];
            $film->release_date = $request['release_date'];
            $film->rating = $request['rating'];
            $film->ticket_price = $request['ticket_price'];
            $film->country = $request['country'];
            $film->photo = $request['photo'];
            $film->save();

            return $this->respondCreated('Film created successfully!', 
            	   $this->filmTransformer->transform($film));

        }catch(JWTException $e){

            return $this->respondInternalError("An error occurred while performing an action!");

        }

    }

    
}
