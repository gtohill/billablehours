<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{    
    protected $fillable =
    [
        'name',
        'description',
        'completed', 
        'time',
        'rate',
        'created_at'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    // set the amout to bill the client for this particular task.
    public function setAmountAttribute(){
        $rate = $this->rate;
        $time = $this->time;        
        $this->attributes['amount'] = round((($time / 3600) * $rate), 2);
    }

}
