@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 style="color: #00008B;"><strong>Messages reçus</strong></h2>
    </div>
    <div class="card-body">
        @if(count($messages) > 0)
            <div class="list-group">
                @foreach($messages as $message)
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $message['sujet'] }}</h5>
                            <small>{{ $message['date'] }}</small>
                        </div>
                        <p class="mb-1">{{ $message['message'] }}</p>
                        <small>De: {{ $message['nom'] }} ({{ $message['email'] }})</small>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <form action="{{ route('messages.destroy', $message['id']) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">Supprimer</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center">Aucun message reçu.</p>
        @endif
    </div>
</div>
@endsection