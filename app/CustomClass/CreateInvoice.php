<?php

namespace App\CustomClass;

use App\Invoice;
use App\Client;

require_once 'FormatTime.php';
require_once '../../vendor/autoload.php';


class CreateInvoice{

    function __construct($invoice_number)
    {
        $invoices = Invoice::select('*')->where('invoice_number', $invoice_number)->get();
        $invoice_date = date('F d, Y');        
        $invoice_number = $invoices[0]->invoice_number;        
                
        // get client
        $client = Client::findorfail($invoices[0]->client_id);

        $html = <<<EOT
<body>
	<div id="page-wrap">

		<div id="header">INVOICE</div>
		
		<div id="identity">
		
            <div id="address">
                $client->name<br>
                1234 Main St <br>
                Anywhere, USA <br>
                10100
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

            <div id="customer-title">$client->name.
                c/o Steve Widget
            </div>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><div>$invoice_number </div></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td>
                        <div id="date">$invoice_date
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due">$875.00</div></td>
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
EOT;
      $invoice_total = 0.00;

      foreach($invoices as $invoice){
        $formatted_time = new FormatTime($invoice->time);
        $time = $formatted_time->get_formatted_time();
        $invoice_total += $invoice->total;

      $html .= <<<EOT
<tr class="item-row">
   <td class="item-name">
      <div class="delete-wpr">
         <div>$invoice->name</div>
      </div>
    </td>
    <td class="description">    
      <div>
        $invoice->description
      </div>
    </td>
    <td><div class="cost">$time</div></td>
    <td><div class="qty">$invoice->rate</div></td>
    <td><span class="price">$invoice->total</span></td>
</tr>
EOT;
      }

      $html .=<<<EOT
 		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">$$invoice_total.00</div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">$$invoice_total.00</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><div id="paid">$0.00</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due">$$invoice_total.00</div></td>
		  </tr>
		
		</table>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <div>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</div>
		</div>	
	</div>	
</body>
EOT;

      // create pdf instance
      $mpdf = new \Mpdf\Mpdf();

      // Write PDF
      $mpdf->WriteHTML($html);

      // Output to Browser
      $mpdf->Output('invoice.pdf', 'D');
    }
}
?>