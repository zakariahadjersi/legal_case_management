<?php

namespace App\Console\Commands;

use App\Models\Audience;
use Illuminate\Console\Command;
use App\Notifications\DatabaseNotification;

class NotifyAudience extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:audience';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to users one day before their audience date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get current date + 1 day
    $tomorrow = now()->addDay();

    // Retrieve all audiences with matching date column value
    $audiences = Audience::whereDate('date', '=', $tomorrow)->get();

    foreach ($audiences as $audience) {
        // Create a new database notification for each user related to that audience.
        $user = $audience->dossierJustice->user;
        $user->notify(new DatabaseNotification(
            $type = 'info', // info / success / warning / error
            $message = 'il y a une audience demain a'.$audience->typecourt,
            $messageLong = 'dossier concerné est '.$audience->dossierJustice->code_affaire.' demain a '.$audience->heur.' au '.$audience->typecourt, // optional
    ));
    }

     return 0;
    }
}
