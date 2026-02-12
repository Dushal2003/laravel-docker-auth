<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;

class PaytmController extends Controller
{
    public function initiatePayment()
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order'         => rand(11111,99999),
            'user'          => auth()->id() ?? 1,
            'mobile_number' => '8586890244',
            'email'         => 'kumardushal2003@gmail.com',
            'amount'        => 10,
            'callback_url'  => env('PAYTM_CALLBACK_URL')
        ]);

        return $payment->receive();
    }

    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();

        if ($transaction->isSuccessful()) {
            return "Payment Successful!";
        } elseif ($transaction->isFailed()) {
            return "Payment Failed!";
        } else {
            return "Payment Processing!";
        }
    }
}
