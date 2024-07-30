<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Module::create(['module' => 'Projet']);
        Module::create(['module' => 'Investisseur']);
        Module::create(['module' => 'Administrateur']);
        Module::create(['module' => 'Conseiller']);
        Module::create(['module' => 'Porteur projet']);
        Module::create(['module' => 'Investissement']);
        Module::create(['module' => 'Profil_investisseur']);
        Module::create(['module' => 'Evenement']);
        Module::create(['module' => 'Message']);
        Module::create(['module' => 'Privilege']);
        Module::create(['module' => 'Secteur_d\'activité']);
        Module::create(['module' => 'Site']);
        Module::create(['module' => 'Archives']);
        Module::create(['module' => 'Actualites']);
        Module::create(['module' => 'Newsletter']);
        Module::create(['module' => 'Profil_porteur_projet']);
        Module::create(['module' => 'Expert']);
    }
}
