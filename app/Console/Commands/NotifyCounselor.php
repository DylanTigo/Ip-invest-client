<?php

namespace App\Console\Commands;

use App\Mail\RelancerConseillerProjetMail;
use App\Models\Projet;
use App\Models\Secteur;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyCounselor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:counselor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifier un conseiller des taches';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('role', 2)->get();
        $days = 15;
        foreach ($users as $user) {
            $count_projets = Projet::where('etat', 'ATTENTE')
                ->whereRaw('datediff(now(), created_at) >= ?', [$days])
                ->whereIn('secteur', function ($query) use ($user) {
                    $query->select('id')
                        ->from(with(new Secteur())->getTable())
                        ->where('user', $user->id);
                })->count();

            if ($count_projets > 0) {
                $data_mail = [
                    'count' => $count_projets,
                    'days' => $days
                ];

                Mail::to($user->email)->queue(new RelancerConseillerProjetMail($data_mail));
            }

            $this->info("$count_projets projets pour " . $user->nom_complet);
        }
    }
}
