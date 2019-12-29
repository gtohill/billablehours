<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\Task;
use App\Invoice;
use App\CustomClass\CreateInvoice;
use App\PostInvoice;
use App\CustomClass\EditTask;


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

        //get last invoice number
        $invoice_number = DB::table('invoices')->latest('invoice_number')->first();

        // total amount owed
        $total = 0.00;        

        foreach ($ids_arr as $id) {            
            
            $task = Task::findorfail($id);
            $sub_total = round((($task->time / 3600) * $client->rate), 2);
            $total += $sub_total;
            array_push($tasks_to_invoices, $sub_total);
            
            // add to invoice table
            $invoice = new Invoice([
                'invoice_number' => (int)$invoice_number->invoice_number + 1,
                'name' => $task->name,
                'description' => $task->description,                
                'time' => $task->time,
                'rate' => $client->rate,
                'total' => $sub_total,
            ]);
            
            // add task to client
            $client->invoices()->save($invoice);    
        }

        // get total amount for this invoice
        foreach($tasks_to_invoices as $in){
            $total += $in;
        }

        // add each task to post_invoice table
        $post_invoice = new PostInvoice([
            'invoice_number'=> (int)$invoice_number->invoice_number + 1,
            'client_id' => $client->id,
            'amount'=> $total
        ]);

        // add post invoice to client
        $client->postinvoices()->save($post_invoice);
                
        // create invoice
        $create_invoice = new CreateInvoice($invoice_number->invoice_number);
        
    }

    /*
    * show all invoices belonging to client based on client id
    */
    public function show($id){
        $client = Client::findorfail($id);
        $invoices = PostInvoice::findorfail($id)->get();
       
        return view('invoice.viewinvoices',
        ['invoices' => $invoices],
        ['client'=>$client]);
    }

    /*
    *   edit an invoice
    */  
    public function edit($invoice_num){

        // get invoice
        $invoices = DB::table('invoices')->where('invoice_number', '=', $invoice_num)->get();

        $invoice_list = array();
        foreach($invoices as $invoice){
            $inv = new EditTask($invoice);
            array_push($invoice_list, $inv);
        }

        // get client
        $client = Client::findorfail($invoices[0]->client_id);


        // send to edit form
        return view(
            'invoice.edit',
            ['invoices'=> $invoice_list],
            ['client'=> $client]
        );
        
    }

    public function update(Request $request){
        // get invoice
        $invoice = DB::table('invoices')->where('invoice_number', '=', (int)request('invoice_number'))->first;
        var_dump($invoice);
       
        // update changes to amount owed
        
        $invoice->amount = (float) request('hiddentotal');
        $invoice->save;
        echo(request('hiddentotal'));
        echo(request('invoice_number'));
        }

}
