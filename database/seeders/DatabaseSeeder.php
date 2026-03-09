<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\UserSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders français pour BiblioTech
        $this->call([
            UserSeeder::class,       // administrateur et quelques utilisateurs
            CategorieSeeder::class,  // Créer d'abord les catégories
            LivreSeeder::class,      // Puis les livres avec relations
        ]);
    }
}
