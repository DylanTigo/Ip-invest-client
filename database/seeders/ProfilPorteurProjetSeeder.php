<?php

namespace Database\Seeders;
use App\Models\ProfilPorteurProjet;
use Illuminate\Database\Seeder;

class ProfilPorteurProjetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProfilPorteurProjet::create([
            'type' => 'PARTICULIER',
            'montant' => '5000'
        ]);
        ProfilPorteurProjet::create([
            'type' => 'ENTREPRISE',
            'montant' => '5000'
        ]);
    }
}
