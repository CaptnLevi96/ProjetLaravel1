<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            $messages = Message::orderBy('created_at', 'desc')->get();
            return view('messages.index', ['messages' => $messages]);
        }
        
        return redirect()->route('home')->with('error', 'Accès non autorisé.');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Création du message dans la base de données
        Message::create($validated);

        return redirect()->back()->with('success', 'Message envoyé avec succès');
    }
}