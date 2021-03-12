<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\OpenTask;
use App\Client;
use App\CustomClass\ClientTasks;

class OpenTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $client = Client::find($id);
        
        // check if an open task exists
        if ($client->opentasks == null) {

            // get task from tasks table and add to open task table
            $current_tasks = $client->tasks;
            $task = $current_tasks->filter(function ($t) {
                if ($t->id == request('id')) {
                    return $t;
                }
            });

            foreach($task as $t){
                $change_to_open_task = $t;
            }
            
            // create new task
            $open_task = new OpenTask(
                [
                    'id'=> $change_to_open_task->id,
                    'name' => $change_to_open_task->name,
                    'description' => $change_to_open_task->description,
                    'status' => 0,
                    'time' => $change_to_open_task->time,
                    'created_at' => $change_to_open_task->created_at
                ]
            );

            // save task to open task table
            $client->opentasks()->save($open_task);

            // save task to tasks table as status 3 
            $change_to_open_task->completed = 3;
            $change_to_open_task->save();

            // rerender page             
           
            $var = new ClientTasks;
            $results = $var->get_tasks($id);
            return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]]);
        }
        else{
            // an error has occured. Can not submit two tasks to open tasks
            $var = new ClientTasks;
            $results = $var->get_tasks($id);
            return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]])->with(['message'=>'Error: Can not have more than one open task at at time']);
        }
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
