<?php

namespace App\CustomClass;

class CheckFormatedTime
{    

    public function __construct($time)
    {
        if(preg_match("/[:]/", $time)){            
            // split each number at :
            $formatted_time = explode(":", $time);                        
            //get hour(s)
            $hours = ((int)$formatted_time[0])*(3600);
            $minutes = ((int)$formatted_time[1]) * 60;
            $seconds = (int)$formatted_time[2];
            $time_in_seconds = $hours + $minutes + $seconds;
            $this->time_secs= $time_in_seconds;
            
        }
        else{
            $this->time_secs = $time;
        }

    }

    public function get_time(){
        return $this->time_secs;
    }

}
?>