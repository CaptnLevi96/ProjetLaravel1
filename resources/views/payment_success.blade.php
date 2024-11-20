@extends('layouts.app')
@section('content')
<div class="container">
<div class="rowjustify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">Paiement Réussi</div>
<div class="card-body">
<p>Votre paiement a été effectué avec succès.</p>
<p>ID de transaction : <strong>{{ $transactionId}}</strong></p>
<a href="{{ route('home') }}" class="btnbtn-primarymt-3">Retour à l'accueil</a>
</div>
</div>
</div>
</div>
</div>
@endsection