@extends('layouts.app')

@section('title', 'Panier')

@section('content')
    <div class="container">
        <h1>Panier</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($panier->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Livre</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($panier as $item)
                        <tr>
                            <td>{{ $item->livre->titre }}</td>
                            <td>{{ $item->livre->prix }} $CAD</td>
                            <td>{{ $item->quantite }}</td>
                            <td>{{ $item->livre->prix * $item->quantite }} $CAD</td>
                            <td>
                                <form action="{{ route('panier.supprimer', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
            <a href="{{ route('paiement.index') }}" class="btn btn-primary">Passer au paiement</a>
            </div>
        @else
            <p>Votre panier est vide.</p>
        @endif
    </div>
@endsection