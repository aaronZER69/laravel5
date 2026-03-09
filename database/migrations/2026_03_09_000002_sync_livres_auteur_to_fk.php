<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // for each livre that has a non-null auteur string, ensure an Auteur record exists
        // and set the foreign key accordingly
        $livres = DB::table('livres')->select('id', 'auteur')->whereNotNull('auteur')->get();

        foreach ($livres as $livre) {
            $nom = trim($livre->auteur);
            if ($nom === '') {
                continue;
            }

            $auteurId = DB::table('auteurs')->where('nom', $nom)->value('id');
            if (!$auteurId) {
                $auteurId = DB::table('auteurs')->insertGetId([
                    'nom' => $nom,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('livres')->where('id', $livre->id)->update(['auteur_id' => $auteurId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // nothing to undo - we don't want to drop authors or clear ids automatically
    }
};
