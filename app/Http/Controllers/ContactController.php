<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $infoBibliotheque = [
            'adresse' => '1234 Rue de la Bibliothèque, Montréal, QC H2X 3Y4',
            'telephone' => '514-123-4567',
            'email' => 'contact@bibliothequelaravelle.ca'
        ];
        
        return view('contact.index', compact('infoBibliotheque'));
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
    
        // Un seul message de succès
        return redirect()->route('contact.index')->with('success', 'Message envoyé avec succès!');
    }
}