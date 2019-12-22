<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = 
    [
        'name',
        'address',
        'city',
        'prov',
        'pc',
        'phone',        
        'user_id',
        'rate'
    ];
    
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function opentasks(){
        return $this->hasOne(OpenTask::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
