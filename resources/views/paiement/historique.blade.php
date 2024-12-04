@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Historique des paiements</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Montant</th>
                    <th>Devise</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->payment_id }}</td>
                        <td>{{ $paiement->user->name }} ({{ $paiement->user->email }})</td>
                        <td>{{ $paiement->amount }}</td>
                        <td>{{ $paiement->currency }}</td>
                        <td>{{ $paiement->payment_status }}</td>
                        <td>{{ $paiement->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection