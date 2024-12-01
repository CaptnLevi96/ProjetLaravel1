@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 style="color: #00008B;"><strong>Formulaire de contact</strong></h2>
            </div>
            <div class="card-body">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                               value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sujet</label>
                        <input type="text" name="sujet" class="form-control @error('sujet') is-invalid @enderror" 
                               value="{{ old('sujet') }}" required>
                        @error('sujet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                  rows="5" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h2 style="color: #00008B;">Informations</h2>
            </div>
            <div class="card-body">
                <h4 style="color: #400102;">Bibliothèque La Ravelle de Montréal</h4>
                <p><strong>Adresse:</strong><br>{{ $infoBibliotheque['adresse'] }}</p>
                <p><strong>Téléphone:</strong><br>{{ $infoBibliotheque['telephone'] }}</p>
                <p><strong>Email:</strong><br>{{ $infoBibliotheque['email'] }}</p>
                <p><strong>Heures d'ouverture:</strong><br>
                    Lundi - Vendredi: 9h à 21h<br>
                    Samedi: 10h à 17h<br>
                    Dimanche: 12h à 17h
                </p>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h2 style="color: #00008B;">Nous localiser</h2>
            </div>
            <div class="card-body">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.1090930928267!2d-73.56601468444707!3d45.50684153789735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc91a49110ccb35%3A0xf0d5412b5a46821b!2sBiblioth%C3%A8que%20La%20Ravelle!5e0!3m2!1sfr!2sca!4v1623680069545!5m2!1sfr!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection