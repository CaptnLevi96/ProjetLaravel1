<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\Panier;

class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        // Configuration de la passerelle PayPal
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);

        // Configuration des options cURL avec le certificat racine
        $this->gateway->initialize([
            'clientId' => env('PAYPAL_CLIENT_ID'),
            'secret' => env('PAYPAL_CLIENT_SECRET'),
            'testMode' => true,
            'sslVerifyPeer' => false,
            'sslVerifyHost' => false,
        ]);
    }

    public function pay(Request $request)
    {
        try {
            // Récupérer le montant total du paiement depuis la requête
            $amount = $request->input('amount');

            // Configurer les détails du paiement
            $response = $this->gateway->purchase([
                'amount' => $amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => secure_url('payment/success'),
                'cancelUrl' => secure_url('payment/error'),
            ])->send();

            // Rediriger vers la page de paiement PayPal
            if ($response->isRedirect()) {
                return $response->redirect();
            } else {
                // En cas d'erreur, afficher le message d'erreur
                return back()->with('error', $response->getMessage());
            }
        } catch (\Exception $e) {
            // En cas d'exception, afficher le message d'erreur
            return back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        // Récupérer les articles du panier de l'utilisateur
        $user = Auth::user();
        $panier = Panier::where('user_id', $user->id)->get();

        // Calculer le total du panier
        $total = $panier->sum(function ($item) {
            return $item->livre->prix * $item->quantite;
        });

        return view('paiement.index', compact('panier', 'total'));
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

    public function historique()
    {
        $paiements = Payment::with('user')->orderBy('created_at', 'desc')->get();
        return view('paiement.historique', compact('paiements'));
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