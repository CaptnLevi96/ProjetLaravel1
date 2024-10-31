@extends('layouts.app')

@section('title', 'Ajouter un livre')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Ajouter un livre</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('livres.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="titre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auteur</label>
                            <input type="text" name="auteur" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Année de publication</label>
                            <input type="number" name="annee_publication" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Résumé</label>
                            <textarea name="resume" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" step="0.01" name="prix" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection