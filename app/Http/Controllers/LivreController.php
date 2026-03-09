<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Categorie;

class LivreController extends Controller
{
    /**
     * Affichage liste avec base de données SQLite
     * SÉANCE 2 : Utiliser Eloquent pour récupérer les données depuis SQLite
     */
    public function index()
    {
        // Récupération des livres avec leurs catégories via Eloquent
        $livres = Livre::with('categorie')->get();

        // Récupération des catégories pour le filtre
        $categories = Categorie::actives()->get();

        $statistiques = [
            'totalLivres' => Livre::count(),
            'livresDisponibles' => Livre::disponible()->count(),
            'totalCategories' => Categorie::actives()->count()
        ];

        return view('livres.index', [
            'livres' => $livres,
            'categories' => $categories,
            'stats' => $statistiques,
            'total' => $livres->count()
        ]);
    }

    /**
     * Affichage détail avec paramètre d'URL et Eloquent
     * SÉANCE 2 : Utiliser Eloquent pour récupérer un enregistrement spécifique
     */
    public function show($id)
    {
        // Conversion de l'ID en entier pour éviter les erreurs
        $id = (int) $id;

        // Récupération du livre avec sa catégorie via Eloquent
        $livre = Livre::with('categorie')->findOrFail($id);

        return view('livres.show', [
            'livre' => $livre
        ]);
    }

    /**
     * Recherche de livres avec Eloquent
     * SÉANCE 2 : Utiliser les scopes Eloquent pour la recherche
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        // Utilisation des scopes Eloquent pour la recherche
        $livres = Livre::with('categorie')
            ->when($query, function ($queryBuilder, $searchTerm) {
                return $queryBuilder->recherche($searchTerm);
            })
            ->get();

        return view('livres.search', [
            'livres' => $livres,
            'query' => $query,
            'total' => $livres->count()
        ]);
    }

    /**
     * Affiche la liste des livres pour l'administrateur (paginé).
     * Protégée par middleware admin via les routes.
     */
    public function adminIndex()
    {
        $livres = Livre::paginate(15);
        return view('admin.livres.index', ['livres' => $livres]);
    }

    /**
     * Affiche le formulaire d'ajout de livre.
     */
    public function create()
    {
        $categories = Categorie::all();
        $auteurs = \App\Models\Auteur::all();
        return view('admin.livres.create', compact('categories', 'auteurs'));
    }

    /**
     * Enregistre un nouveau livre envoyé depuis le formulaire.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur_id' => 'nullable|exists:auteurs,id',
            'new_auteur' => 'nullable|string|max:255',
            'annee' => 'nullable|integer',
            'nb_pages' => 'nullable|integer',
            'isbn' => 'nullable|string|max:20',
            'resume' => 'nullable|string',
            'disponible' => 'required|boolean',
            'categorie_id' => 'nullable|exists:categories,id',
        ]);

        // if new_auteur provided, create author record
        if (!empty($validated['new_auteur'])) {
            $auteur = \App\Models\Auteur::firstOrCreate(['nom' => $validated['new_auteur']]);
            $validated['auteur_id'] = $auteur->id;
        }

        // fill legacy auteur string so NOT NULL constraint is satisfied
        if (!empty($validated['auteur_id'])) {
            $auteur = \App\Models\Auteur::find($validated['auteur_id']);
            $validated['auteur'] = $auteur?->nom ?? '';
        }

        // if neither auteur_id nor new_auteur provided, require auteur text
        if (empty($validated['auteur_id']) && empty($validated['new_auteur'])) {
            $request->validate(['auteur' => 'required|string|max:255']);
            $validated['auteur'] = $request->input('auteur');
        }

        Livre::create($validated);

        return redirect()->route('admin.livres.index')->with('success', 'Livre ajouté');
    }

    /**
     * Supprime un livre du catalogue.
     */
    public function destroy($id)
    {
        $livre = Livre::findOrFail($id);
        $livre->delete();

        return redirect()->route('admin.livres.index')->with('success', 'Livre supprimé');
    }
}
