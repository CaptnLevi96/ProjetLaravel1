<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    private function getLivres()
    {
        $json = Storage::get('public/livres.json');
        return json_decode($json, true)['livres'];
    }

    private function saveLivres($livres)
    {
        try {
            $success = Storage::put('public/livres.json', json_encode(['livres' => $livres], JSON_PRETTY_PRINT));
            if (!$success) {
                \Log::error('Impossible de sauvegarder les livres');
            }
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde des livres: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $livres = $this->getLivres();
        return view('livres.index', compact('livres'));
    }

    public function create()
    {
        return view('livres.create');
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

        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès');
    }

    public function show($id)
    {
        $livres = $this->getLivres();
        $livre = collect($livres)->firstWhere('id', (int)$id);
        return view('livres.show', compact('livre'));
    }

    public function destroy($id)
    {
        $livres = $this->getLivres();
        $livres = array_filter($livres, function($livre) use ($id) {
            return $livre['id'] != $id;
        });
        $this->saveLivres(array_values($livres));
        return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès');
    }

    public function search(Request $request)
    {
        $livres = $this->getLivres();
        $query = strtolower($request->get('query')); // Correction ici
        
        if (empty($query)) {
            return redirect()->route('livres.index');
        }
        
        $livres = array_filter($livres, function($livre) use ($query) {
            return strpos(strtolower($livre['titre']), $query) !== false ||
                   strpos(strtolower($livre['auteur']), $query) !== false ||
                   strpos((string)$livre['annee_publication'], $query) !== false;
        });
    
        return view('livres.index', ['livres' => array_values($livres)]);
    }
}