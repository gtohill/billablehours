<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Task;
use App\OpenTask;
use App\CustomClass\ClientTasks;
use App\CustomClass\EditTask;
use Illuminate\Support\Facades\DB;


class ClientTasksController extends Controller
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
        return view('accounts.createtask');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //get information from form 
        $clientid = request('clientid'); // get client id
        $status = 1; //signifies task is in progress

        // create new task
        $task = new Task(
            [
                'name' => request('name'),
                'description' => request('description'),
                'completed' => $status,
                'rate' => request('rate'),
                'time' => 0.00

            ]
        );
        // get client
        $client = Client::findorfail($clientid);
        // add task to client
        $client->tasks()->save($task);

        return view('accounts.createtask')->with(['client' => $client])->with(['message' => 'Success! Task was created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get client information
        $var = new ClientTasks;
        $results = $var->get_tasks($id);
        return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get task and return view
        if (auth()->user()) {

            $task = Task::findorfail($id);

            $edited_task = new EditTask($task);

            // get client
            $client = Client::findorfail($task->client_id);
            return view('task.edit')->with(['task' => $edited_task])->with(['client' => $client]);
        } else {
            // user is not logged in - redirect to error page
            return redirect('errors.loginrequired');
        }
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
        // get the client
        $client = Client::find($id);

        // get task by id
        $all_tasks = $client->tasks;
        $hidden_task = $all_tasks->filter(function ($task) {
            if ($task->completed == 3) {
                return $task;
            }
        });

        // change hidden task back to inprogress 
        foreach ($hidden_task as $task) {

            $task->completed = 1;
            $task->time =  (int) request('actual');
            $task->save();
        }

        // delete open task from table
        $delete_open_task = $client->opentasks;
        if (!isset($delete_open_task->id)) {
            //abort(403, "unauthorized request");
            $var = new ClientTasks;
            $results = $var->get_tasks($id);
            return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]]);
        }

        $client->opentasks()->delete($delete_open_task->id);

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
        // get task
        $task = Task::findorfail($id);

        // get client
        $client = Client::findorfail($task->client_id);

        // delete task
        DB::table('tasks')->where('id', $id)->delete();

        //return to tasks view
        $client_tasks = new ClientTasks;
        $results = $client_tasks->get_tasks($client->id);
        return view('accounts.clienttasks')->with(['client' => $results[0]])->with(['openTask' => $results[1]])->with(['tasksInProgress' => $results[2]])->with(['completedTasks' => $results[3]]);
    }

    /*
    custom controllers
    */
    public function createtask($id)
    {

        $client = Client::find($id);

        return view('accounts.createtask')->with(['client' => $client]);
    }

    /*
    * edit task from edit form
    */
    public function edittask(Request $request)
    {


        // get client       
        $task = Task::findorfail(request('id'));

        $client = Client::findorfail($task->client_id);

        $task->name = request('name');
        $task->description = request('description');

        //convert time back to seconds
        $second = (int)request('second');
        $minute = (int)request('minute') * 60;
        $hour = (int)request('hour') * 3600;
        $total_seconds = $second + $minute + $hour;

        // save edited task to database
        $task->time = $total_seconds;
        $task->setAmountAttribute();
        $task->save();

        $etask = new EditTask($task);
        return view('task.edit')->with(['task' => $etask])->with(['client' => $client])->with(['message' => 'Success: Task is updated']);
    }
}
