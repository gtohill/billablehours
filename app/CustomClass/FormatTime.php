<?php

namespace App\CustomClass;

class FormatTime
{
    
    private $seconds = 0;
    private $minutes = 0;
    private $hours = 0;

    public function __construct($time)
    {   
        $actual_time = (int)$time;                
        $this->seconds = $actual_time % 60;
        $this->minutes = floor($actual_time / 60) % 60;
        $this->hours = floor(($actual_time / (60 * 60)) % 24);
        
    }

    public function get_formatted_time(){        
        $formatted = $this->hours .' h '.$this->minutes.' m '.$this->seconds.' s' ;
        return (string)$formatted;
    }
}
   

?>