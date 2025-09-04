<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    // Tracker la visite
    public function track(Request $request)
    {
       $ip = $request->ip();

        // Vérifier si l'IP existe déjà (unique dans la table)
        $exists = Visit::where('ip', $ip)->exists();

        if (!$exists) {
            // récupérer le pays depuis une API gratuite (ip-api.com par ex.)
            $response = Http::get("http://ip-api.com/json/{$ip}?fields=country");

            $pays = $response->successful() ? $response->json('country') : 'Inconnu';

            // créer la visite
            Visit::create([
                'ip'   => $ip,
                'pays' => $pays,
            ]);
        }

        return response()->json(['message' => 'Visit tracked']);
    }

    // Récupérer les stats globales
    public function summary()
    {
        $totalVisits = Visit::count();
        $uniqueVisitors = Visit::distinct('ip')->count('ip');
        $pageViews = $totalVisits; // Chaque visite = une page vue

        return response()->json([
            'totalVisits' => $totalVisits,
            'uniqueVisitors' => $uniqueVisitors,
            'pageViews' => $pageViews
        ]);
    }

    // Récupérer les visites mensuelles pour l'année en cours
    public function monthly()
    {
        $data = Visit::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as visits'),
        DB::raw('COUNT(DISTINCT ip) as uniqueVisitors'),
        DB::raw('COUNT(*) as pageViews') // Ajout pour correspondre au graphique
    )
    ->whereYear('created_at', now()->year)
    ->groupBy(DB::raw('MONTH(created_at)'))
    ->orderBy('month')
    ->get();

    return response()->json($data);
    }
}
