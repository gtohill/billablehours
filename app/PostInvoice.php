<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostInvoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'client_id',
        'amount'       
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
