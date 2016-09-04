<?php

namespace App\Http\Controllers;

use PayPal;
use Illuminate\Http\Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PayPalController extends Controller
{
    public function __construct()
    {
    }   


    private function getOrderDetail(){

        $data = [];
        $data['items'] = [
            [
                'name' => 'Product 3.99',
                'price' => 3.99,
                'qty' => 1,
            ]
        ];

        $data['invoice_id'] = 1001;
        $data['invoice_description'] = $data['invoice_id'];
        $data['return_url'] = url('/payment/success');
        $data['cancel_url'] = url('/cart');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price'];
        }

        $data['total'] = $total;

        return $data ;

    }

    public function createPayment()
    {
/*
        $data = [];
        $data['items'] = [
            [
                'name' => 'Product 3.99',
                'price' => 3.99,
                'qty' => 1,
            ]
        ];

        $data['invoice_id'] = 1001;
        $data['invoice_description'] = $data['invoice_id'];
        $data['return_url'] = url('/payment/success');
        $data['cancel_url'] = url('/cart');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price'];
        }

        $data['total'] = $total;
*/

        $data = $this->getOrderDetail();



        // Use the following line when creating recurring payment profiles (subscriptions)
        $response = PayPal::getProvider()->setExpressCheckout($data, true);

         // This will redirect user to PayPal
        return redirect($response['paypal_link']);

    }   

    public function getPaymentStatus( Request $request )
    {
        $response = PayPal::getProvider()->getExpressCheckoutDetails($request->token);

/*
        $data['items'] = [
            [
                'name' => 'Product 1',
                'price' => 9.99,
                'qty' => 1,
            ]
        ];

        $data['total'] = 9.99;
        $data['invoice_id'] = 4;
        $data['invoice_description'] = $data['invoice_id'];
        $data['return_url'] = url('/payment/success');
        $data['cancel_url'] = url('/cart');

*/
        $data = $this->getOrderDetail();


        $response = PayPal::getProvider()->doExpressCheckoutPayment($data, $response['TOKEN'], $response['PAYERID']);

        /*
        $data = [
            'CURRENCYCODE' => 'BRL',
            'PROFILESTARTDATE' => \Carbon\Carbon::now()->addDays(14)->toAtomString(),
            'DESC' => 4,
            'BILLINGPERIOD' => 'Month', // Can be 'Day', 'Week', 'SemiMonth', 'Month', 'Year'
            'BILLINGFREQUENCY' => 1, // set 12 for monthly, 52 for yearly
            'AMT' => 9.99, // Billing amount for each billing cycle
            'CURRENCYCODE' => 'BRL', // Currency code 
            'TRIALBILLINGPERIOD' => 'Day',  // (Optional) Can be 'Day', 'Week', 'SemiMonth', 'Month', 'Year'
            'TRIALBILLINGFREQUENCY' => 14, // (Optional) set 12 for monthly, 52 for yearly 
            'TRIALTOTALBILLINGCYCLES' => 1, // (Optional) Change it accordingly
            'TRIALAMT' => 0, // (Optional) Change it accordingly
        ];
        */
        //$response = PayPal::getProvider()->createRecurringPaymentsProfile($data, $request->token);
        //$response = PayPal::getProvider()->doExpressCheckoutPayment($data, $request->token, $request->PayerID);
        dd($response);
    }
}