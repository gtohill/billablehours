<?php

namespace App\CustomClass;

class CheckFormatTime
{
    private $time_in_seconds;

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
            $this->time_in_seconds = $time_in_seconds;
            return $this->time_in_seconds;
        }

        return $time;

    }
    

}


?>