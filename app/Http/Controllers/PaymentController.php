<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;

class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        // Configuration de la passerelle PayPal
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); // Passez à false en production
    }

    public function pay(Request $request)
    {
        try {
            $response = $this->gateway->purchase([
                'amount' => $request->amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('payment/success'),
                'cancelUrl' => url('payment/error'),
            ])->send();

            if ($response->isRedirect()) {
                return $response->redirect();
            } else {
                return $response->getMessage();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ])->send();

            $response = $transaction->getData();

            if ($response['state'] === 'approved') {
                // Sauvegarde des informations du paiement
                $payment = new Payment();
                $payment->payment_id = $response['id'];
                $payment->payer_id = $response['payer']['payer_info']['payer_id'];
                $payment->payer_email = $response['payer']['payer_info']['email'];
                $payment->amount = $response['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $response['state'];
                $payment->save();

                return view('payment_success', [
                    'transactionId' => $response['id']
                ]);
            } else {
                return 'Paiement non approuvé.';
            }
        } else {
            return 'Paiement échoué.';
        }
    }

    public function error()
    {
        return 'Utilisateur a annulé le paiement.';
    }

    public function showPaymentForm()
    {
        return view('payment_form');
    }
}
