<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    private function getMessages()
    {
        $json = Storage::get('public/messages.json');
        return json_decode($json, true)['messages'];
    }

    private function saveMessages($messages)
    {
        Storage::put('public/messages.json', json_encode(['messages' => $messages], JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $infoBibliotheque = [
            'adresse' => '123 Rue de laRavelle',
            'telephone' => '514-383-3824',
            'email' => 'LaRavelle@bibliotheque.ca'
        ];
        return view('contact.index', compact('infoBibliotheque'));
    }

    public function store(Request $request)
    {
        $messages = $this->getMessages();
        
        $nouveauMessage = [
            'id' => count($messages) + 1,
            'nom' => $request->nom,
            'email' => $request->email,
            'sujet' => $request->sujet,
            'message' => $request->message,
            'date' => date('Y-m-d H:i:s')
        ];

        $messages[] = $nouveauMessage;
        $this->saveMessages($messages);

        return redirect()->route('contact.index')->with('success', 'Message envoyé avec succès');
    }
}