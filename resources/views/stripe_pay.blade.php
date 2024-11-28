@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">
                   <h2>Paiement par carte</h2>
               </div>
               <div class="card-body">
                   <form action="{{ route('stripe.pay') }}" method="POST" id="payment-form">
                       @csrf
                       <div class="mb-3">
                           <label class="form-label">Email</label>
                           <input type="email" name="email" class="form-control" required>
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Montant ($)</label>
                           <input type="number" name="amount" class="form-control" required>
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Informations de carte</label>
                           <div class="card p-3">
                               <div class="mb-3">
                                   <label class="form-label">Numéro de carte</label>
                                   <input type="text" class="form-control" id="card-number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                               </div>
                               <div class="row">
                                   <div class="col-md-6 mb-3">
                                       <label class="form-label">Date d'expiration (MM/AA)</label>
                                       <input type="text" class="form-control" id="card-expiry" placeholder="MM/AA" maxlength="5" required>
                                   </div>
                                   <div class="col-md-6 mb-3">
                                       <label class="form-label">CVC</label>
                                       <input type="text" class="form-control" id="card-cvc" placeholder="123" maxlength="3" required>
                                   </div>
                               </div>
                               <div class="mb-3">
                                   <label class="form-label">Code postal</label>
                                   <input type="text" class="form-control" id="postal-code" placeholder="H1H 1H1" required>
                               </div>
                           </div>
                           <div id="card-errors" class="text-danger mt-2"></div>
                       </div>
                       <button type="submit" class="btn btn-primary">Payer</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
   const stripe = Stripe('{{ env('STRIPE_KEY') }}');

   // Formatage du numéro de carte
   document.getElementById('card-number').addEventListener('input', function(e) {
       let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
       let formattedValue = '';
       for(let i = 0; i < value.length; i++) {
           if(i > 0 && i % 4 === 0) {
               formattedValue += ' ';
           }
           formattedValue += value[i];
       }
       e.target.value = formattedValue;
   });

   // Formatage de la date d'expiration
   document.getElementById('card-expiry').addEventListener('input', function(e) {
       let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
       if(value.length > 2) {
           value = value.substr(0,2) + '/' + value.substr(2);
       }
       e.target.value = value;
   });

   // Limiter le CVC à 3 chiffres
   document.getElementById('card-cvc').addEventListener('input', function(e) {
       e.target.value = e.target.value.replace(/[^0-9]/g, '').substr(0,3);
   });

   const form = document.getElementById('payment-form');
   form.addEventListener('submit', function(event) {
       event.preventDefault();

       const cardNumber = document.getElementById('card-number').value.replace(/\s+/g, '');
       const expiry = document.getElementById('card-expiry').value.split('/');
       const exp_month = expiry[0];
       const exp_year = '20' + expiry[1];
       const cvc = document.getElementById('card-cvc').value;
       const postal_code = document.getElementById('postal-code').value;

       stripe.createToken({
           number: cardNumber,
           exp_month: parseInt(exp_month),
           exp_year: parseInt(exp_year),
           cvc: cvc,
           address_zip: postal_code
       }).then(function(result) {
           if (result.error) {
               const errorElement = document.getElementById('card-errors');
               errorElement.textContent = result.error.message;
           } else {
               const hiddenInput = document.createElement('input');
               hiddenInput.setAttribute('type', 'hidden');
               hiddenInput.setAttribute('name', 'stripeToken');
               hiddenInput.setAttribute('value', result.token.id);
               form.appendChild(hiddenInput);
               form.submit();
           }
       });
   });
</script>
@endsection