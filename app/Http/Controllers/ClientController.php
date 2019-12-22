<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\User;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset(auth()->user()->id)){
            
            // user id
            $user_id = auth()->user()->id;

            // get user details
            $user = User::findorfail($user_id);
            $clients = $user->clients;

            // show results           
            return view('accounts.clients')->with(['clients' => $clients ]);
        }
        else{

            // if user is not logged in.
            return view('errors.loginrequired');
        }       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(isset(auth()->user()->id)){            

            return view('accounts.create');

        }
        else{
            return view('errors.loginrequired');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $this->validate($request, [

            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pc' => 'required',
            'prov' => 'required',
            'phone' => 'required', 
            'rate' => 'required',

        ]);
        
        Client::create([
            'name'=> request('name'),
            'address'=> request('address'),
            'city'=> request('city'),
            'pc'=> request('pc'),
            'prov' => request('prov'),
            'phone'=> request('phone'),            
            'user_id' => auth()->user()->id,
            'rate'=> request('rate')            
        ]);

        return redirect('/accounts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //client id (not user id)
        $id = $id;
        
        // is user logged in?
        if(isset(auth()->user()->id)){            
            
            // get user id
            $user_id = auth()->user()->id;
            
            // get users clients
            $user = User::findorfail($user_id);

             // get all clients
            $all_clients = $user->clients;            
           $client;
            // get the client we want.
           foreach($all_clients as $clnt){
               if($clnt->id == $id){
                   $client = $clnt;
               }
           }

           
            return view('accounts.client')->with(['client' => $client]);

        }
        else{
            return view('errors.loginrequired');
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
