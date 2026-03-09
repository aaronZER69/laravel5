<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('livres', function (Blueprint $table) {
            $table->foreignId('auteur_id')->nullable()->after('titre')->constrained('auteurs')->nullOnDelete();
            // we keep the existing `auteur` string for compatibility briefly
        });
    }

    public function down()
    {
        Schema::table('livres', function (Blueprint $table) {
            $table->dropForeign(['auteur_id']);
            $table->dropColumn('auteur_id');
        });
    }
};
