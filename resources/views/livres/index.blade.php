@extends('layouts.app')  

@section('title', 'Liste des livres')  

@section('content')     
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);
        </script>
    @endif

    <div class="row mb-4">         
        <div class="col">             
            <h1 style="color: #06402b;"><strong>Liste des livres</strong></h1>         
        </div>         
        <div class="col text-end">             
            <a href="{{ route('livres.create') }}" class="btn btn-primary">Ajouter un Livre</a>         
        </div>     
    </div>      

    <div class="mb-4">         
        <form action="{{ route('livres.search') }}" method="GET" class="row g-3">             
            <div class="col-md-8">                 
                <input type="text" name="query" class="form-control" placeholder="Rechercher par titre, auteur ou année...">             
            </div>             
            <div class="col-md-4">                 
                <button type="submit" class="btn btn-secondary">Rechercher</button>             
            </div>         
        </form>     
    </div>      

    <div class="row row-cols-1 row-cols-md-3 g-4">         
        @foreach($livres as $livre)
            <div class="col">                 
                <div class="card h-100">                     
                    <div class="card-body">                         
                        <h5 class="card-title">
                            {{ $livre['titre'] }}
                            @if(in_array($livre->id, $recentLivres))
                                <span class="badge bg-danger ms-2">Nouveauté</span>
                            @endif
                        </h5>                         
                        <h6 class="card-subtitle mb-2 text-muted">{{ $livre['auteur'] }}</h6>                         
                        <p class="card-text">                         
                            Année: {{ $livre['annee_publication'] }}<br>                         
                            Prix: {{ $livre['prix'] }} $CAD                         
                        </p>                         
                        <div class="d-flex gap-2">
                            <a href="{{ route('livres.show', $livre['id']) }}" class="btn btn-info">Détails</a>
                            <form action="{{ route('panier.ajouter', $livre['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-cart-plus"></i> Ajouter au panier
                                </button>
                            </form>
                        </div>
                    </div>                
                </div>         
            </div>         
        @endforeach     
    </div> 
@endsection