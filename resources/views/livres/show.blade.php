@extends('layouts.app')

@section('title', $livre['titre'])

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2>Détails du livre</h2>
        <a href="{{ route('livres.index') }}" class="btn btn-secondary">Retour</a>
    </div>
    <div class="card-body">
        <h3 class="card-title">{{ $livre['titre'] }}</h3>
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Auteur:</strong> {{ $livre['auteur'] }}</p>
                <p><strong>Année de publication:</strong> {{ $livre['annee_publication'] }}</p>
                <p><strong>Prix:</strong> {{ $livre['prix'] }} $CAD</p>
            </div>
            <div class="col-md-6">
                <p><strong>Date d'ajout:</strong> {{ $livre['date_creation'] }}</p>
                <p><strong>Dernière modification:</strong> {{ $livre['date_modification'] }}</p>
            </div>
        </div>
        <div class="mb-4">
            <h4>Résumé</h4>
            <p>{{ $livre['resume'] }}</p>
        </div>
        <form action="{{ route('livres.destroy', $livre['id']) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>
@endsection