<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Audience;
use Illuminate\Support\Facades\DB;
use App\Models\DossierJustice;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use Backpack\Generators\Console\Commands\ChartBackpackCommand;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{



public function getChartData(Request $request)
{
    $labels = [
        'en préparation',
        "à l'inspection de travail",
        'au tribunal',
        'à la cour',
        'à la cour suprême',
        'Gagné',
        'Perdu',
    ];

    $agenceId = $request->input('agence_id');
  /*  
    $results = DossierJustice::select('state', DB::raw('COUNT(*) as count'))
    ->groupBy('state')
    ->get()
    ->toArray();
*/
 /*  $results = DB::table('dossier_justices')
    ->rightJoin(
        DB::raw("
            (SELECT 'Préparation' AS state UNION ALL
            SELECT 'à l\'inspection de travail' AS state UNION ALL
            SELECT 'au tribunal' AS state UNION ALL
            SELECT 'à la cour' AS state UNION ALL
            SELECT 'à la cour suprême' AS state UNION ALL
            SELECT 'En Cours' AS state UNION ALL
            SELECT 'Gagné' AS state UNION ALL
            SELECT 'Perdu' AS state) AS states
        "),
        'states.state',
        '=',
        'dossier_justices.state'
    )
    ->select('states.state', DB::raw('COUNT(dossier_justices.state) as count'))
    ->groupBy('states.state')
    ->get();



$dataset = [
    'count' => [],
];

foreach ($results as $result) {
    $dataset['count'][$result->state] = $result->count;
}

foreach ($labels as $state) {
    if (!array_key_exists($state, $dataset['count'])) {
        $dataset['count'][$state] = 0;
    }
}

ksort($dataset['count']);
*/
$states = DossierJustice::select('state', DB::raw('COUNT(*) as count'))
    ->where('agence_id', $agenceId)
    ->groupBy('state')
    ->get();

// Create an array to store the result
$results = [];

// Iterate through each "secteur" and assign the count to the result array
foreach ($states as $state) {
    $results[$state->state] = $state->count;
}

ksort($results);
$secteurs = DossierJustice::select('secteur', DB::raw('COUNT(*) as count'))
    ->where('agence_id', $agenceId)
    ->groupBy('secteur')
    ->get();

// Create an array to store the result
$results2 = [];

// Iterate through each "secteur" and assign the count to the result array
foreach ($secteurs as $secteur) {
    $results2[$secteur->secteur] = $secteur->count;
}

ksort($results2);
return [
    'labels' => $labels,
    'datasets' => $results,
    'datasets2'=> $results2
];
}

public function dashboard()
{
   //   $chart = $this->getChartData();
    //$latestAudience = Audience::latest()->first();
    $latestAudience = Audience::orderBy('date', 'asc')
                    ->limit(1)
                    ->pluck('date')
                    ->first();
    $agences = Agence::all();               
    return view(backpack_view('dashboard'), compact('agences','latestAudience'));
}


    //
}
