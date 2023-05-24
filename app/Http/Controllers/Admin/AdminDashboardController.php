<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use Illuminate\Support\Facades\DB;
use App\Models\DossierJustice;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use Backpack\Generators\Console\Commands\ChartBackpackCommand;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{



public function getChartData()
{
  /*  
    $results = DossierJustice::select('state', DB::raw('COUNT(*) as count'))
    ->groupBy('state')
    ->get()
    ->toArray();
*/
   $results = DB::table('dossier_justices')
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

$labels = [
    'Préparation',
    "à l'inspection de travail",
    'au tribunal',
    'à la cour',
    'à la cour suprême',
    'En Cours',
    'Gagné',
    'Perdu',
];

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

return [
    'labels' => $labels,
    'datasets' => array_values($dataset['count']),
];
}

public function dashboard()
{
   //   $chart = $this->getChartData();
    //$latestAudience = Audience::latest()->first();
    $latestAudience = Audience::orderBy('created_at', 'desc')
                    ->limit(1)
                    ->pluck('date')
                    ->first();
    return view(backpack_view('dashboard'), compact('latestAudience'));
}


    //
}
