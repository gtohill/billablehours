<?php

namespace App\CustomClass;

use App\Client;
use App\Task;
use App\OpenTask;
require_once 'FormatTime.php';

class ClientTasks
{
    function get_tasks($id)
    {
        $client = Client::find($id);
        $tasks = $client->tasks;
        $open_task = $client->opentasks;
        $tasks_in_progress = $tasks->filter(function ($task) {
            if ($task->completed == 1) {
                $format_time = new FormatTime($task->time);
                $task->time = $format_time->get_formatted_time();
                return $task;
            }
        });

        $completed_tasks = $tasks->filter(function ($task) {
            if ($task->completed == 2) {
                $format_time = new FormatTime($task->time);
                $task->time = $format_time->get_formatted_time();
                return $task;
            }
        });

        $var = [$client, $open_task, $tasks_in_progress, $completed_tasks];
        return $var;
    }
}
