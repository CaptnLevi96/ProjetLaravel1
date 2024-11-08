@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
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
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sujet</label>
                        <input type="text" name="sujet" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h2 style="color: #00008B;" >Informations</h2>
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
    </div>
</div>
@endsection