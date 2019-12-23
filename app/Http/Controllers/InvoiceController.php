<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\Task;
use App\Invoice;
use App\CustomClass\CreateInvoice;
use App\PostInvoice;


class InvoiceController extends Controller
{
    public function invoice(Request $request)
    {

        // get client
        $client = Client::findorfail(request('client_id'));

        // get rate
        $rate = $client->rate;

        // get tasks
        $ids_arr = request('services');

        // array to save invoice data
        $tasks_to_invoices = array();

        // total amount owed
        $total = 0.00;

        //get last invoice number
        $invoice_number = DB::table('invoices')->latest('invoice_number')->first();

        foreach ($ids_arr as $id) {
            $task = Task::findorfail($id);
            $total += round((($task->time / 3600) * $client->rate), 2);
            //$t = ['name'=>$task->name, 'description'=>$task->description, 'rate'=>$client->rate, 'time'=>$task->time, 'total'=>round((($task->time / 3600) * $client->rate), 2)];
            //array_push($tasks_to_invoices, $t);

            // add to invoice table
            $invoice = new Invoice([
                'invoice_number' => (int)$invoice_number->invoice_number + 1,
                'name' => $task->name,
                'description' => $task->description,                
                'time' => $task->time,
                'rate' => $client->rate,
                'total' => $total,
            ]);
            
            // add task to client
            $client->invoices()->save($invoice);

            // add each task to post_invoice table
            $post_invoice = new PostInvoice([
                'invoice_number'=> (int)$invoice_number->invoice_number + 1,
                'client_id' => $client->id,
                'amount'=> $total
            ]);

            // add post invoice to client
            $client->postinvoices()->save($post_invoice);
        }
        
        //generate invoice

        // create invoice
        $create_invoice = new CreateInvoice($invoice_number->invoice_number);
        
    }

}
