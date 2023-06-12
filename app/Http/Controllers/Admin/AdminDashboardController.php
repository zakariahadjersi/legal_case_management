<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Audience;
use App\Models\Court;
use Illuminate\Support\Carbon;
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
    $labels = [
        'en préparation',
        "à l'inspection de travail",
        'au tribunal',
        'à la cour',
        'à la cour suprême',
        'Gagné',
        'Perdu',
    ];

$user = backpack_user();    
$agenceId = $user->agence_id;
$direction = backpack_user()->agence->direction;
$touslesagence = $direction->agences->pluck('id');

// Super Admin can be shown chart of all dossier justice
  if ($user->hasRole('Super Admin')) {
    $states = DossierJustice::select('state', DB::raw('COUNT(*) as count'))
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

//Direction can be shown chart of all dossier justice of his direction and under
if ($user->hasRole('Direction Consultant') || $user->hasRole('Direction Admin') || $user->hasRole('Direction Author')) {
    $states = DossierJustice::select('state', DB::raw('COUNT(*) as count'))
    ->whereIn('agence_id', $touslesagence)
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

// agence can be shown chart of all dossier justice under his agence
if ($user->hasRole('Agence Consultant') || $user->hasRole('Agence Admin') || $user->hasRole('Agence Author')) {
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

}

public function dashboard()
{   $user = backpack_user();  

    // Super Admin is shown the closest audience in all CTC
    if ($user->hasRole('Super Admin')) {
    $latestAudienceData = Audience::select('date', 'heur', 'court_id')
    ->where('date', '>=', Carbon::now()->toDateString())
    ->orderBy('date', 'asc')
    ->first();

$latestAudience = $latestAudienceData->date ?? null;
$latestAudienceHeure = $latestAudienceData->heur ?? null;
$latestAudienceCourId = $latestAudienceData->court_id ?? null;

$latestAudienceCour = Court::where('id', '=', $latestAudienceCourId)
    ->pluck('adresse')
    ->first();
        return view(backpack_view('dashboard'), compact('latestAudience','latestAudienceHeure','latestAudienceCour'));
    }

     // Direction is shown the closest audience in under his direction
        $direction = backpack_user()->agence->direction;
        $touslesagence = $direction->agences->pluck('id');
     if ($user->hasRole('Direction Consultant') || $user->hasRole('Direction Admin') || $user->hasRole('Direction Author')) {
        $latestAudienceData = Audience::select('date', 'heur', 'court_id')
                             ->join('dossier_justices as dj', 'audiences.dossier_justice_id', '=', 'dj.id')
                             ->join('agences as ag', 'dj.agence_id', '=', 'ag.id')
                             ->whereIn('dj.agence_id', $touslesagence)
                             ->where('date', '>=', Carbon::now()->toDateString())
                             ->orderBy('date', 'asc')
                             ->first();

$latestAudience = $latestAudienceData->date ?? null;
$latestAudienceHeure = $latestAudienceData->heur ?? null;
$latestAudienceCourId = $latestAudienceData->court_id ?? null;

$latestAudienceCour = Court::where('id', '=', $latestAudienceCourId)
    ->pluck('adresse')
    ->first();
        return view(backpack_view('dashboard'), compact('latestAudience','latestAudienceHeure','latestAudienceCour'));
    }

     // Agence is shown the closest audience in his direction
     
    $agenceId = $user->agence_id;
     if ($user->hasRole('Agence Consultant') || $user->hasRole('Agence Admin') || $user->hasRole('Agence Author')) {
        $latestAudienceData = Audience::select('date', 'heur', 'court_id')
                ->join('dossier_justices as dj', 'audiences.dossier_justice_id', '=', 'dj.id')
                ->where('dj.agence_id', $agenceId)
                ->where('date', '>=', Carbon::now()->toDateString())
                ->orderBy('date', 'asc')
                ->first();
                $latestAudience = $latestAudienceData->date ?? null;
                $latestAudienceHeure = $latestAudienceData->heur ?? null;
                $latestAudienceCourId = $latestAudienceData->court_id ?? null;
                
                $latestAudienceCour = Court::where('id', '=', $latestAudienceCourId)
                    ->pluck('adresse')
                    ->first();
        return view(backpack_view('dashboard'), compact('latestAudience','latestAudienceHeure','latestAudienceCour'));
    }
}

}
