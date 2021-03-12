<?php

namespace App\CustomClass;

class EditTask
{
    public function __construct($task){

        $this->id = $task->id;
        $this->invoice_number = $task->invoice_number;
        $this->name = $task->name;
        $this->description = $task->description;
        $this->rate = $task->rate;
        $this->total = $task->total;
        $this->created_at = $task->created_at;
        
        // convert time
        $actual_time = $task->time;
        $seconds = $actual_time % 60;
        $minutes = floor($actual_time / 60) % 60;
        $hours = floor(($actual_time / (60 * 60)) % 24);

        $this->hour = ($hours < 10) ? "0".$hours : $hours;
        $this->minute = $minutes;
        $this->second = $seconds;

    }

}