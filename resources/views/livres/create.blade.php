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
                   @if($errors->any())
                       <div class="alert alert-danger">
                           <ul>
                               @foreach($errors->all() as $error)
                                   <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                       </div>
                   @endif

                   @if(session('error'))
                       <div class="alert alert-danger">
                           {{ session('error') }}
                       </div>
                   @endif

                   <form action="{{ route('livres.store') }}" method="POST">
                       @csrf
                       <div class="mb-3">
                           <label class="form-label">Titre</label>
                           <input type="text" name="titre" 
                                  class="form-control @error('titre') is-invalid @enderror" 
                                  value="{{ old('titre') }}" required>
                           @error('titre')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Auteur</label>
                           <input type="text" name="auteur" 
                                  class="form-control @error('auteur') is-invalid @enderror" 
                                  value="{{ old('auteur') }}" required>
                           @error('auteur')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Année de publication</label>
                           <input type="number" name="annee_publication" 
                                  class="form-control @error('annee_publication') is-invalid @enderror" 
                                  value="{{ old('annee_publication') }}" required>
                           @error('annee_publication')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Résumé</label>
                           <textarea name="resume" 
                                     class="form-control @error('resume') is-invalid @enderror" 
                                     rows="3" required>{{ old('resume') }}</textarea>
                           @error('resume')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>
                       <div class="mb-3">
                           <label class="form-label">Prix</label>
                           <input type="number" step="0.01" name="prix" 
                                  class="form-control @error('prix') is-invalid @enderror" 
                                  value="{{ old('prix') }}" required>
                           @error('prix')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                       </div>
                       <button type="submit" class="btn btn-primary">Ajouter</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
@endsection