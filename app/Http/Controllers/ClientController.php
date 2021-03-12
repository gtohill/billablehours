<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;  
use App\Http\Controllers\Controller;
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

        ]);
        
        Client::create([
            'name'=> request('name'),
            'address'=> request('address'),
            'city'=> request('city'),
            'pc'=> request('pc'),
            'prov' => request('prov'),
            'phone'=> request('phone'),            
            'user_id' => auth()->user()->id,            
        ]);

        return redirect('/accounts')->with(["message"=>"Success! Client was created."]);
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
            // get the client we want.
            foreach($all_clients as $clnt){
               if($clnt->id == $id){
                   $client = $clnt;
               }
           }

            // get the number of active tasks
            $tasks = DB::select('select * from tasks where completed = 1');  
            $active_tasks = count($tasks);
            $completed_tasks = DB::select('select * from tasks where completed = 2');
            if(count($completed_tasks) > 0){
                $percent_completed = (count($completed_tasks)/(count($completed_tasks) + $active_tasks))*100;
            }else{
                $percent_completed = 0;
            }           

            // get invoice amounts            
            $invoice = DB::table('invoices')->where('client_id', '=', $client->id)->get();            
            
            // get total invoice completed
            $total_invoice  = 0;
            foreach($invoice as $in){
                $total_invoice = $total_invoice + $in->total;
            }
           
            return view('accounts.client')
            ->with(['client' => $client])
            ->with(['num_tasks'=> $active_tasks])
            ->with(['perc_completed'=>$percent_completed])
            ->with(['completed'=>count($completed_tasks)])
            ->with(['invoice'=>$total_invoice]);

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
