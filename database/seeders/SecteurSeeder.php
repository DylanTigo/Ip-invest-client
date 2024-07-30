<?php

namespace Database\Seeders;

use App\Models\Secteur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Secteur::create(['libelle' => 'Numérique', 'slug' => Str::slug('Numérique'), 'user' => 2]);
        Secteur::create(['libelle' => 'Forêt & Bois', 'slug' => Str::slug('Forêt & Bois'), 'user' => 2]);
        Secteur::create(['libelle' => 'Agro Industrie', 'slug' => Str::slug('Agro Industrie'), 'user' => 2]);
        Secteur::create(['libelle' => 'Immobiliers', 'slug' => Str::slug('Numerique'), 'user' => 2]);
        Secteur::create(['libelle' => 'Textiles confection & Cuir', 'slug' => Str::slug('Numerique'), 'user' => 2]);
        Secteur::create(['libelle' => "Industrie de l'energie", 'slug' => Str::slug("Industrie de l'energie"), 'user' => 2]);
    }
}
