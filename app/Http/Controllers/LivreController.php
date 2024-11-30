<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LivreController extends Controller
{
    public function index()
    {
        $livres = Livre::orderBy('created_at', 'desc')->get();
        return view('livres.index', compact('livres'));
    }

    public function create()
    {
        return view('livres.create');
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'titre' => 'required|string|max:255',
                'auteur' => 'required|string|max:255',
                'annee_publication' => 'required|integer|min:1000|max:' . (date('Y') + 1),
                'resume' => 'required|string',
                'prix' => 'required|numeric|min:0',
            ]);
    
            if ($validator->fails()) {
                \Log::error('Validation failed: ' . json_encode($validator->errors()));
                return redirect()
                    ->route('livres.create')
                    ->withErrors($validator)
                    ->withInput();
            }
    
            // Log des données reçues
            \Log::info('Données reçues:', $request->all());
    
            $livre = Livre::create([
                'titre' => $request->titre,
                'auteur' => $request->auteur,
                'annee_publication' => $request->annee_publication,
                'resume' => $request->resume,
                'prix' => $request->prix,
                'date_creation' => now(),
                'date_modification' => now()
            ]);
    
            \Log::info('Livre créé avec succès:', $livre->toArray());
    
            return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du livre: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()
                ->route('livres.create')
                ->with('error', 'Une erreur est survenue lors de l\'ajout du livre')
                ->withInput();
        }
    }
    public function show($id)
    {
        $livre = Livre::findOrFail($id);
        return view('livres.show', compact('livre'));
    }

    public function destroy($id)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            $livre = Livre::findOrFail($id);
            $livre->delete();
            return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès');
        }
    
        return redirect()->route('livres.index')->with('error', 'Accès non autorisé.');
    }

    public function search(Request $request)
    {
        $query = $request->get('query', '');
        
        if (empty($query)) {
            return redirect()->route('livres.index');
        }
        
        $livres = Livre::where('titre', 'LIKE', "%{$query}%")
                      ->orWhere('auteur', 'LIKE', "%{$query}%")
                      ->orWhere('annee_publication', 'LIKE', "%{$query}%")
                      ->get();
    
        return view('livres.index', compact('livres'));
    }
}