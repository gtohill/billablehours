<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostInvoice extends Model
{
    public $table = 'postinvoices';

    protected $fillable =[
        'client_id',
        'invoice_number',
        'amount'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
