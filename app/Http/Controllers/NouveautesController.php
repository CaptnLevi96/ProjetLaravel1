<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Carbon\Carbon;

class NouveautesController extends Controller
{
    public function index()
    {
        // Récupérer les livres des 10 derniers jours depuis la base de données
        $nouveautes = Livre::where('created_at', '>=', Carbon::now()->subDays(10))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('nouveautes.index', ['livres' => $nouveautes]);
    }
}