<?php

namespace App\CustomClass;

use App\Client;
use App\Task;
use App\OpenTask;
require_once 'FormatTime.php';


class ClientTasks
{
     /**
     * Input client id and create an array that 
     * returns Open Tasks, In Progress Tasks, and Completed Tasks.     *
     * @return Array
     */
    function get_tasks($id)
    {
        // get client by id
        $client = Client::find($id);
        // get all task for this client
        $tasks = $client->tasks;
        // get the open task
        $open_task = $client->opentasks;
        
        // get task in progress
        $tasks_in_progress = $tasks->filter(function ($task) {
            if ($task->completed == 1) {
                // format the time from raw integer to hours:mins:seconds
                $format_time = new FormatTime($task->time);
                $task->time = $format_time->get_formatted_time();
                return $task;
            }
        });
        // get completed tasks
        $completed_tasks = $tasks->filter(function ($task) {
            if ($task->completed == 2) {
                // format the time from raw integer to hours:mins:seconds
                $format_time = new FormatTime($task->time);
                $task->time = $format_time->get_formatted_time();
                return $task;
            }
        });

        $package_tasks = [$client, $open_task, $tasks_in_progress, $completed_tasks];
        return $package_tasks;
    }
}
