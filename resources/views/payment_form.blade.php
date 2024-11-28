@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">
                   <h2>Choisissez votre méthode de paiement</h2>
               </div>
               <div class="card-body">
                   <!-- PayPal Form -->
                   <div class="mb-5">
                       <h3>Option 1 : PayPal</h3>
                       <form action="{{ route('payment.pay') }}" method="POST">
                           @csrf
                           <div class="mb-3">
                               <label class="form-label">Montant ($)</label>
                               <input type="number" name="amount" class="form-control" step="0.01" required>
                           </div>
                           <button type="submit" class="btn btn-primary">
                               <i class="bi bi-paypal"></i> Payer avec PayPal
                           </button>
                       </form>
                   </div>

                   <hr>

                   <!-- Stripe Section -->
                   <div class="mt-5">
                       <h3>Option 2 : Paiement par carte avec Stripe</h3>
                       <p>Paiement sécurisé par carte de crédit</p>
                       <a href="{{ route('stripe.form') }}" class="btn btn-info">
                           <i class="bi bi-credit-card"></i> Payer par carte
                       </a>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection