<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{

    private function saveMessages($messages)
{
    try {
        $success = Storage::put('public/messages.json', json_encode(['messages' => $messages], JSON_PRETTY_PRINT));
        if (!$success) {
            \Log::error('Impossible de sauvegarder les messages');
        }
    } catch (\Exception $e) {
        \Log::error('Erreur lors de la sauvegarde des messages: ' . $e->getMessage());
    }
}

    private function getMessages()
    {
        if (!Storage::exists('public/messages.json')) {
            Storage::put('public/messages.json', json_encode(['messages' => []]));
        }

        $json = Storage::get('public/messages.json');
        $data = json_decode($json, true);
        return $data['messages'] ?? [];
    }

    public function index()
    {
        $messages = $this->getMessages();
        return view('messages.index', ['messages' => $messages]);
    }


    public function store(Request $request)
{
    $livres = $this->getLivres();
    
    $nouveauLivre = [
        'id' => count($livres) + 1,
        'titre' => $request->titre,
        'auteur' => $request->auteur,
        'annee_publication' => $request->annee_publication,
        'resume' => $request->resume,
        'prix' => $request->prix,
        'date_creation' => date('Y-m-d'),
        'date_modification' => date('Y-m-d')
    ];

    $livres[] = $nouveauLivre;
    $this->saveLivres($livres);

    $contenuActuel = Storage::get('public/livres.json');
    \Log::info('Contenu du fichier après sauvegarde: ' . $contenuActuel);

    return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès');
}



}