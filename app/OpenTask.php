<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpenTask extends Model
{
    public $incrementing = false;

    protected  $fillable = 
    [
        'id',
        'name',
        'description',
        'status',
        'time',
        'created_at'
    ];

    public function clients(){
        return $this->belongsTo(Client::class);
    }
}
