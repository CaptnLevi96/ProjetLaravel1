@extends('layouts.app')

@section('title', 'Modifier un livre')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Modifier un livre</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('livres.update', $livre->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre', $livre->titre) }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Auteur</label>
                            <input type="text" name="auteur" class="form-control @error('auteur') is-invalid @enderror" value="{{ old('auteur', $livre->auteur) }}" required>
                            @error('auteur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Année de publication</label>
                            <input type="number" name="annee_publication" class="form-control @error('annee_publication') is-invalid @enderror" value="{{ old('annee_publication', $livre->annee_publication) }}" required>
                            @error('annee_publication')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Résumé</label>
                            <textarea name="resume" class="form-control @error('resume') is-invalid @enderror" rows="3" required>{{ old('resume', $livre->resume) }}</textarea>
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" step="0.01" name="prix" class="form-control @error('prix') is-invalid @enderror" value="{{ old('prix', $livre->prix) }}" required>
                            @error('prix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <a href="{{ route('livres.show', $livre->id) }}" class="btn btn-secondary ms-2">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection