@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Formulaire de paiement</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.pay') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Montant ($)</label>
                            <input type="number" name="amount" class="form-control" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Payer avec PayPal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection