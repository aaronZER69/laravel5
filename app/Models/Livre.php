<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $table = 'livres';

    protected $fillable = [
        'titre',
        'auteur',        // legacy field, will be kept for backward compatibility
        'auteur_id',     // new foreign key
        'annee',
        'nb_pages',
        'isbn',
        'resume',
        'couverture',
        'disponible',
        'categorie_id'
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'annee' => 'integer',
        'nb_pages' => 'integer'
    ];

    /**
     * Scope pour les livres disponibles
     */
    public function scopeDisponible($query)
    {
        return $query->where('disponible', true);
    }

    /**
     * Scope pour rechercher par titre ou auteur (ou nom de l'auteur lié).
     */
    public function scopeRecherche($query, $terme)
    {
        return $query->where('titre', 'like', '%' . $terme . '%')
            ->orWhere('auteur', 'like', '%' . $terme . '%')
            ->orWhereHas('auteurRel', function ($q) use ($terme) {
                $q->where('nom', 'like', "%$terme%");
            });
    }

    /**
     * Un livre appartient à une catégorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Un livre peut appartenir à un auteur enregistré.
     */
    public function auteurRel()
    {
        return $this->belongsTo(Auteur::class, 'auteur_id');
    }

    /**
     * Scope pour filtrer par catégorie
     */
    public function scopeParCategorie($query, $categorieNom)
    {
        return $query->where('categorie', $categorieNom);
    }

    /**
     * Scope pour filtrer par catégorie via relation
     */
    public function scopeParCategorieSlug($query, $categorieSlug)
    {
        return $query->whereHas('categorie', function ($q) use ($categorieSlug) {
            $q->where('slug', $categorieSlug);
        });
    }

    /**
     * Accesseur pour l'URL du livre
     */
    public function getUrlAttribute()
    {
        return route('livre.show', $this->id);
    }
}
