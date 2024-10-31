<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NouveautesController extends Controller
{
    private function getLivres()
    {
        if (!Storage::exists('public/livres.json')) {
            Storage::put('public/livres.json', json_encode(['livres' => []]));
        }

        $json = Storage::get('public/livres.json');
        $data = json_decode($json, true);
        return $data['livres'] ?? [];
    }

    public function index()
    {
        $livres = $this->getLivres();
        
        // Filtrer les livres des 10 derniers jours
        $nouveautes = array_filter($livres, function($livre) {
            $dateCreation = Carbon::parse($livre['date_creation']);
            return $dateCreation->diffInDays(Carbon::now()) <= 10;
        });

        return view('nouveautes.index', ['livres' => array_values($nouveautes)]);
    }
}