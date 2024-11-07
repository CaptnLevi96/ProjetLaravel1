@extends('layouts.app')

@section('title', 'Nouveautés')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 style="color: #00008B;"><strong>Nouveautés des 10 derniers jours</strong></h2>
    </div>
    <div class="card-body">
        @if(count($livres) > 0)
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($livres as $livre)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $livre['titre'] }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $livre['auteur'] }}</h6>
                                <p class="card-text">
                                    <small>Ajouté le: {{ $livre['date_creation'] }}</small><br>
                                    Prix: {{ $livre['prix'] }} $CAD
                                </p>
                                <a href="{{ route('livres.show', $livre['id']) }}" class="btn btn-info">Voir les détails</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center">Aucune nouveauté pour le moment.</p>
        @endif
    </div>
</div>
@endsection