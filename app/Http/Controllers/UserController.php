<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Response; 

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    protected function checkRecaptcha($token, $ip) { 


        $response = (new Client)->post('https://www.google.com/recaptcha/api/siteverify', 
        [ 
            'form_params' => [ 
                'secret' => '6Lfr7SsdAAAAAAGFCfW8LVMD2pER9oKdRZC-pqly', 
                'response' => $token, 
                'remoteip' => $ip, 
            ], 
        ]); 
        $response = json_decode((string)$response->getBody(), true); 
        return $response['success']; 
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {   
        
        if (config('recaptcha.enabled') && !$this->checkRecaptcha($request->token, $request->ip())) { 
            return response()->json([ 'error' => 'Captcha is invalid.', ], Response::HTTP_BAD_REQUEST); 
        } 

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')

        ]);

        $user->save();

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {

        $user = User::findOrFail($id);
        if($user){
            $user->update($request->all());
        }
        
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user){
            $user->delete();
        }        

        return response()->json('User deleted!');
    }


    

}
