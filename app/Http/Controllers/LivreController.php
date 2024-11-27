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

        Livre::create([
            'titre' => $request->titre,
            'auteur' => $request->auteur,
            'annee_publication' => $request->annee_publication,
            'resume' => $request->resume,
            'prix' => $request->prix,
            'date_creation' => now(),
            'date_modification' => now()
        ]);

        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès');
    }

    public function show($id)
    {
        $livre = Livre::findOrFail($id);
        return view('livres.show', compact('livre'));
    }

    public function destroy($id)
    {
        $livre = Livre::findOrFail($id);
        $livre->delete();

        return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès');
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