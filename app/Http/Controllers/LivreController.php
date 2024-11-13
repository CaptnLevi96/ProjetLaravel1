<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LivreController extends Controller
{
    private function getLivres()
    {
        try {
            $json = Storage::get('public/livres.json');
            return json_decode($json, true)['livres'] ?? [];
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la lecture des livres: ' . $e->getMessage());
            return [];
        }
    }

    private function saveLivres($livres)
    {
        try {
            $success = Storage::put('public/livres.json', json_encode(['livres' => $livres], JSON_PRETTY_PRINT));
            if (!$success) {
                throw new \Exception('Échec de la sauvegarde du fichier');
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde des livres: ' . $e->getMessage());
            return false;
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
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'annee_publication' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'resume' => 'required|string',
            'prix' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('livres.create')
                ->withErrors($validator)
                ->withInput();
        }

        $livres = $this->getLivres();
        
        $nouveauLivre = [
            'id' => $this->getNextId($livres),
            'titre' => $request->titre,
            'auteur' => $request->auteur,
            'annee_publication' => $request->annee_publication,
            'resume' => $request->resume,
            'prix' => $request->prix,
            'date_creation' => date('Y-m-d'),
            'date_modification' => date('Y-m-d')
        ];

        $livres[] = $nouveauLivre;
        
        if ($this->saveLivres($livres)) {
            return redirect()
                ->route('livres.index')
                ->with('success', 'Livre ajouté avec succès');
        }

        return redirect()
            ->route('livres.create')
            ->with('error', 'Une erreur est survenue lors de l\'ajout du livre')
            ->withInput();
    }

    public function show($id)
    {
        $livres = $this->getLivres();
        $livre = collect($livres)->firstWhere('id', (int)$id);
        
        if (!$livre) {
            return redirect()
                ->route('livres.index')
                ->with('error', 'Livre non trouvé');
        }

        return view('livres.show', compact('livre'));
    }

    public function edit($id)
    {
        $livres = $this->getLivres();
        $livre = collect($livres)->firstWhere('id', (int)$id);
        
        if (!$livre) {
            return redirect()
                ->route('livres.index')
                ->with('error', 'Livre non trouvé');
        }

        return view('livres.edit', compact('livre'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'annee_publication' => 'required|integer|min:1000|max:' . (date('Y') + 1),
            'resume' => 'required|string',
            'prix' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('livres.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $livres = $this->getLivres();
        $index = array_search($id, array_column($livres, 'id'));
        
        if ($index === false) {
            return redirect()
                ->route('livres.index')
                ->with('error', 'Livre non trouvé');
        }

        $livres[$index] = [
            'id' => (int)$id,
            'titre' => $request->titre,
            'auteur' => $request->auteur,
            'annee_publication' => $request->annee_publication,
            'resume' => $request->resume,
            'prix' => $request->prix,
            'date_creation' => $livres[$index]['date_creation'],
            'date_modification' => date('Y-m-d')
        ];

        if ($this->saveLivres($livres)) {
            return redirect()
                ->route('livres.show', $id)
                ->with('success', 'Livre modifié avec succès');
        }

        return redirect()
            ->route('livres.edit', $id)
            ->with('error', 'Une erreur est survenue lors de la modification du livre')
            ->withInput();
    }

    public function destroy($id)
    {
        $livres = $this->getLivres();
        $livresFiltered = array_filter($livres, function($livre) use ($id) {
            return $livre['id'] != $id;
        });

        if (count($livres) === count($livresFiltered)) {
            return redirect()
                ->route('livres.index')
                ->with('error', 'Livre non trouvé');
        }

        if ($this->saveLivres(array_values($livresFiltered))) {
            return redirect()
                ->route('livres.index')
                ->with('success', 'Livre supprimé avec succès');
        }

        return redirect()
            ->route('livres.index')
            ->with('error', 'Une erreur est survenue lors de la suppression du livre');
    }

    public function search(Request $request)
    {
        $query = strtolower($request->get('query', ''));
        
        if (empty($query)) {
            return redirect()->route('livres.index');
        }
        
        $livres = $this->getLivres();
        $livresFiltered = array_filter($livres, function($livre) use ($query) {
            return strpos(strtolower($livre['titre']), $query) !== false ||
                   strpos(strtolower($livre['auteur']), $query) !== false ||
                   strpos((string)$livre['annee_publication'], $query) !== false;
        });
    
        return view('livres.index', ['livres' => array_values($livresFiltered)]);
    }

    private function getNextId($livres)
    {
        if (empty($livres)) {
            return 1;
        }
        return max(array_column($livres, 'id')) + 1;
    }
}