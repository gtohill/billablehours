@extends('layouts.app')

@section('account')
    <table class="table table-hover">
        <thead>
          <tr>
            <th>Invoice Number</th>
            <th>Amount</th> 
            <th>Edit</th>           
          </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
            <td>{{$invoice->invoice_number}}</td>
            
            <td>{{$invoice->amount}}</td>
            <td><a href="/invoice/{{$invoice->invoice_number}}/edit">Edit</a></td>
            </tr>          
            @endforeach
        </tbody>
      </table>
   
@endsection