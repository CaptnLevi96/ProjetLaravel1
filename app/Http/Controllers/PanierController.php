<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    public function ajouter(Request $request, Livre $livre)
    {
        $user = Auth::user();

        $panier = Panier::where('user_id', $user->id)
            ->where('livre_id', $livre->id)
            ->first();

        if ($panier) {
            $panier->increment('quantite');
        } else {
            Panier::create([
                'user_id' => $user->id,
                'livre_id' => $livre->id,
                'quantite' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Le livre a été ajouté au panier.');
    }

    public function index()
    {
        $user = Auth::user();
        $panier = Panier::where('user_id', $user->id)->get();

        return view('panier.index', compact('panier'));
    }

    public function supprimer(Panier $panier)
    {
        $panier->delete();

        return redirect()->route('panier.index')->with('success', 'L\'article a été supprimé du panier.');
    }
}