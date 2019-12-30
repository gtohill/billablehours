<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Task;
use App\OpenTask;
use App\CustomClass\ClientTasks;
use App\CustomClass\EditTask;
use App\CustomClass\FormatTime;
use Exception;

class CompletedTasksController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get client
        $client = Client::findorfail($id);

        // get tasks
        $all_tasks = $client->tasks;

         // get all completed tasks
         $completed = $all_tasks->filter(function ($task) {
            if ($task->completed == 2) {
                return $task;
            }
        });

        $completed_tasks = [];

        foreach($completed as $aTask){
            $aTask->setAmountAttribute();
            $time = new FormatTime($aTask->time);            
            $aTask->time = $time->get_formatted_time();             
            array_push($completed_tasks, $aTask);
        }
               
        // display results
        return view('accounts.finishedtasks')->with(['completed_tasks' => $completed_tasks])->with(['client'=>$client]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get completed task
        $completed_task = Task::find($id);

        // change to in progress
        $completed_task->completed = 1;
        $completed_task->save();

        // get client id
        $client_id = $completed_task->client_id;

        // render web page         
        $var = new ClientTasks;
        $results = $var->get_tasks($client_id);
        return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]]);
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
        // get client 
        $client = Client::find($id);

        // get actual time of task from request        
        $time_in_seconds = request('actual2');

        // update task in task table
        // get all tasks
        $all_tasks = $client->tasks;

        // get task to close
        $task_to_close = $all_tasks->filter(function ($task) {
            if ($task->id == request('id')) {
                return $task;
            }
        });

        // complete task
        foreach ($task_to_close as $task) {
            //$task->time = $time_in_seconds;
            $task->completed = 2;
            $client->tasks()->save($task);
        }
        try {
            // delete task for open task table with identical id.
            $open_task = $client->opentasks;

            if ($open_task->id == request('id')) {
                $client->opentasks()->delete($open_task);
            }
        } catch (Exception $e) {
            // render view        
            $var = new ClientTasks;
            $results = $var->get_tasks($id);
            return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]]);
        }
        
        // render view        
        $var = new ClientTasks;
        $results = $var->get_tasks($id);
        return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]]);
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
