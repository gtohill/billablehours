<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = 
    [
        'invoice_number',
        'name',
        'description',
        'rate',
        'time',
        'total'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
