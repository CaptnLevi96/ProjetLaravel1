<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\StripePayment;

class StripePaymentController extends Controller
{
    public function showForm()
    {
        return view('stripe_pay');
    }

    public function pay(Request $request)
    {
        // Validation plus stricte des données
        $validated = $request->validate([
            'stripeToken' => 'required|string',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            // Configuration de Stripe avec vérification de la clé
            $stripeKey = env('STRIPE_SECRET_KEY');
            if (!$stripeKey) {
                throw new \Exception('La clé Stripe n\'est pas configurée.');
            }
            Stripe::setApiKey($stripeKey);

            // Vérification de la devise
            $currency = env('STRIPE_CURRENCY', 'usd');
            if (!$currency) {
                throw new \Exception('La devise n\'est pas configurée.');
            }

            // Conversion du montant en centimes et arrondi
            $amount = round($validated['amount'] * 100);

            // Création du paiement avec gestion des erreurs
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $currency,
                'source' => $validated['stripeToken'],
                'description' => 'Paiement de ' . $validated['email'],
                'metadata' => [
                    'email' => $validated['email']
                ]
            ]);

            // Vérification du statut du paiement
            if ($charge->status !== 'succeeded') {
                throw new \Exception('Le paiement n\'a pas été validé.');
            }

            // Enregistrement dans la base de données
            $payment = new StripePayment([
                'payment_id' => $charge->id,
                'payer_email' => $validated['email'],
                'amount' => $validated['amount'],
                'currency' => $currency,
                'payment_status' => $charge->status,
            ]);

            if (!$payment->save()) {
                throw new \Exception('Erreur lors de l\'enregistrement du paiement.');
            }

            // Redirection vers la page de succès
            return redirect()->route('payment.success')->with([
                'transactionId' => $charge->id,
                'paymentMethod' => 'stripe',
                'success' => 'Paiement effectué avec succès!'
            ]);

        } catch (\Stripe\Exception\CardException $e) {
            // Erreur liée à la carte
            return redirect()->back()->withErrors([
                'card_error' => $e->getMessage()
            ])->withInput();

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Erreur de requête Stripe
            return redirect()->back()->withErrors([
                'stripe_error' => 'Erreur de requête: ' . $e->getMessage()
            ])->withInput();

        } catch (\Exception $e) {
            // Autres erreurs
            return redirect()->back()->withErrors([
                'error' => 'Une erreur est survenue: ' . $e->getMessage()
            ])->withInput();
        }
    }
}