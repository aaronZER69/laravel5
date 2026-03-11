<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Str;

class CategorieController extends Controller
{
    /**
     * Affiche la liste des catégories pour l'administrateur.
     */
    public function adminIndex()
    {
        $categories = Categorie::paginate(15);
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Affiche le formulaire d'ajout de catégorie.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Enregistre une nouvelle catégorie.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['nom']);

        Categorie::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée');
    }

    /**
     * Affiche le formulaire de modification d'une catégorie.
     */
    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('admin.categories.edit', ['categorie' => $categorie]);
    }

    /**
     * Met à jour une catégorie.
     */
    public function update(Request $request, $id)
    {
        $categorie = Categorie::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $id,
            'description' => 'nullable|string',
        ]);

        // Générer le slug si le nom a changé
        if ($categorie->nom !== $validated['nom']) {
            $validated['slug'] = Str::slug($validated['nom']);
        }

        $categorie->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie modifiée');
    }

    /**
     * Supprime une catégorie.
     */
    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);

        // Détacher les livres de cette catégorie (mettre categorie_id à NULL)
        $categorie->livres()->update(['categorie_id' => null]);

        $categorie->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée. Les livres associés ont été détachés de cette catégorie.');
    }
}
