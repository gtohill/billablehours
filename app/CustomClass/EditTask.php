<?php

namespace App\CustomClass;

class EditTask
{
    public function __construct($task){

        $this->id = $task->id;
        $this->name = $task->name;
        $this->description = $task->description;
        
        // convert time
        $actual_time = $task->time;
        $seconds = $actual_time % 60;
        $minutes = floor($actual_time / 60) % 60;
        $hours = floor(($actual_time / (60 * 60)) % 24);

        $this->hour = $hours;
        $this->minute = $minutes;
        $this->second = $seconds;

    }

}