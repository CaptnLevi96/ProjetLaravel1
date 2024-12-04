@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Paiement</h1>

        <h3>Résumé du panier</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($panier as $item)
                    <tr>
                        <td>{{ $item->livre->titre }}</td>
                        <td>{{ $item->livre->prix }} $CAD</td>
                        <td>{{ $item->quantite }}</td>
                        <td>{{ $item->livre->prix * $item->quantite }} $CAD</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>Total à payer : {{ $total }} $CAD</p>

        <form action="{{ route('payment.form') }}" method="GET">
            @csrf
            <input type="hidden" name="amount" value="{{ $total }}">
            <button type="submit" class="btn btn-primary">Procéder au paiement</button>
        </form>
    </div>
@endsection