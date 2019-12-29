@extends('layouts.app')
@section('account')

<link href="{{ asset('css/invoice.css') }}" rel="stylesheet">


<div id="page-wrap">

    <div id="header">INVOICE</div>

    <div id="identity">

        <div id="address">
            {{$client->name}}<br>
            {{$client->address}} <br>
            {{$client->city}}, {{$client->prov}} <br>
            {{$client->pc}}
        </div>

        <div id="logo">

            <div id="logoctr">
                <a href="" id="change-logo" title="Change logo">Change Logo</a>
                <a href="" id="save-logo" title="Save changes">Save</a>
                |
                <a href="" id="delete-logo" title="Delete logo">Delete Logo</a>
                <a href="" id="cancel-logo" title="Cancel changes">Cancel</a>
            </div>

            <div id="logohelp">
                <input id="imageloc" type="text" size="50" value="" /><br />
            </div>
        </div>

    </div>

    <div style="clear:both"></div>

    <div id="customer">

        <div id="customer-title">
            {{$client->name}}
        </div>

        <table id="meta">
            <tr>
                <td class="meta-head">Invoice #</td>
                <td>
                    <div>{{$invoices[0]->invoice_number}} </div>
                </td>
            </tr>
            <tr>

                <td class="meta-head">Date</td>
                <td>
                    <div id="date">{{ $invoices[0]->created_at }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="meta-head">Amount Due</td>
                <td>
                    <div id="amount_due" class="due"></div>
                </td>
            </tr>

        </table>

    </div>

    <table id="items">  
        <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Labour</th>
            <th>Rate</th>
            <th>Price</th>
        </tr>
    <form action="/invoice/update" method="POST">
        @csrf
        <input type="text" name="invoice_number" id="invoice_number" hidden value="{{$invoices[0]->invoice_number}}">
        <input type="text" name="hiddentotal" id="hiddentotal" hidden>
        <input type="submit" value="Update">
    </form>
        @foreach($invoices as $invoice)       

            <tr class="item-row">
                <td class="item-name">
                    <div class="delete-wpr">
                        <div>{{$invoice->name}}</div>
                    </div>
                </td>
                <td class="description">
                    <div>
                        {{$invoice->description}}
                    </div>
                </td>
                <td>
                    <input id="appt-time" type="time" name="tasktime" value="{{$invoice->hour}}:{{$invoice->minute}}">                              
                </td>
                <td>
                    <input type="text" name="rate" class="qty" value="{{$invoice->rate}}">                    
                </td>
                <td>
                    <input type="text" class="price" name="total" class="" onchange="amountChange();"value="{{$invoice->total}}">                   
                </td>
            </tr>
            @endforeach

            <td colspan="2" class="blank"> </td>
            <td colspan="2" class="total-line">Sub-Total</td>
            <td class="total-value">
                <div id="subtotal"></div>
            </td>
            </tr>
            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line">Total</td>
                <td class="total-value">
                    <div id="total"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line">Amount Paid</td>

                <td class="total-value">
                    <div id="paid">$0.00</div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="2" class="total-line balance">Balance Due</td>
                <td class="total-value balance">
                    <div id="amountdue" class="due"></div>
                </td>
            </tr>
               
    </table>

    <div id="terms">
        <h5>Terms</h5>
        <div>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div>
</div>

<script>
    
    let amountArr = document.getElementsByClassName('price');
    let total = 0.00;

    for(var i = 0; i < amountArr.length; i++){
        total = total + parseFloat(amountArr[i].value);
    }   
    document.getElementById("total").innerHTML = "$"+total;
    document.getElementById("subtotal").innerHTML = "$"+total;
    document.getElementById("amountdue").innerHTML = "$"+total;
    document.getElementById("hiddentotal").value = "$"+total;


    console.log(total);


    function amountChange(){
        let amountArr = document.getElementsByClassName('price');
        let total = 0.00;

        for(var i = 0; i < amountArr.length; i++){
            total = total + parseFloat(amountArr[i].value);
        }   
        document.getElementById("total").innerHTML = "$"+total;
        document.getElementById("subtotal").innerHTML = "$"+total;
        document.getElementById("amountdue").innerHTML = "$"+total;
        document.getElementById("hiddentotal").value = "$"+total;


    }

</script>
@endsection