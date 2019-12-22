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
        'created_at'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
