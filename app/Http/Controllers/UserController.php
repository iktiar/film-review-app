<?php 

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use Response;
use App\Repository\Transformers\UserTransformer;
use \Illuminate\Http\Response as Res;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends ApiController
{
    /**
     * @var \App\Repository\Transformers\UserTransformer
     * */
    protected $userTransformer;


    public function __construct(userTransformer $userTransformer)
    {

        $this->userTransformer = $userTransformer;

    }


    /**
     * @description: Api user authenticate method
     * @author: Adelekan David Aderemi
     * @param: email, password
     * @return: Json String response
     */
    public function authenticate(Request $request)
    {

        $rules = array (

            'email' => 'required|email',
            'password' => 'required',

        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator-> fails()){

            return $this->respondValidationError('Fields Validation Failed.', $validator->errors());

        }

        else{

            $user = User::where('email', $request['email'])->first();

            if($user){
                $api_token = $user->api_token;

                if ($api_token == NULL){
                    return $this->_login($request['email'], $request['password']);
                }

                try{

                    $user = JWTAuth::toUser($api_token);

                    return $this->respond([

                        'status' => 'success',
                        'status_code' => $this->getStatusCode(),
                        'message' => 'Already logged in',
                        'user' => $this->userTransformer->transform($user)
                    ]);

                }catch(JWTException $e){

                    $user->api_token = NULL;
                    $user->save();

                    return $this->respondInternalError("Login Unsuccessful: ".$e);

                }
            }
            else{
                return $this->respondWithError("Invalid Email or Password");
            }

        }

    }


    private function _login($email, $password)
    {

        $credentials = ['email' => $email, 'password' => $password];


        if ( ! $token = JWTAuth::attempt($credentials)) {

            return $this->respondWithError("User does not exist!");

        }

        $user = JWTAuth::toUser($token);

        $user->api_token = $token;
        $user->save();

        return $this->respond([

            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Login successful!',
            'data' => $this->userTransformer->transform($user)

        ]);
    }


    /**
     * @description: Api user register method
     * @author: Adelekan David Aderemi
     * @param: lastname, firstname, username, email, password
     * @return: Json String response
     */
    public function register(Request $request)
    {

        $rules = array (

            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:3'

        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator-> fails()){

            return $this->respondValidationError('Fields Validation Failed.', $validator->errors());

        }

        else{

            $user = User::create([

                'name' => $request['name'],
                'email' => $request['email'],
                'password' => \Hash::make($request['password']),

            ]);

            return $this->_login($request['email'], $request['password']);

        }

    }


    /**
     * @description: Api user logout method
     * @author: Adelekan David Aderemi
     * @param: null
     * @return: Json String response
     */
    public function logout($api_token)
    {

        try{

            $user = JWTAuth::toUser($api_token);

            $user->api_token = NULL;

            $user->save();

            JWTAuth::setToken($api_token)->invalidate();

            $this->setStatusCode(Res::HTTP_OK);

            return $this->respond([

                'status' => 'success',
                'status_code' => $this->getStatusCode(),
                'message' => 'Logout successful!',

            ]);


        }catch(JWTException $e){

            return $this->respondInternalError("An error occurred while performing an action!");

        }

    }

}











