@extends('layouts.app', [
    'title' => 'Modifier un livre',
    'breadcrumbs' => [
        ['label' => 'Accueil', 'url' => route('home')],
        ['label' => 'Administration', 'url' => route('admin.dashboard')],
        ['label' => 'Livres', 'url' => route('admin.livres.index')],
        ['label' => 'Modifier', 'url' => null],
    ],
])

@section('content')
<div class="container">
    <h2>Modifier le livre</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.livres.update', $livre->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre', $livre->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="auteur_id" class="form-label">Auteur</label>
            <select name="auteur_id" id="auteur_id" class="form-select">
                <option value="">-- Choisir un auteur existant --</option>
                @foreach($auteurs as $aut)
                    <option value="{{ $aut->id }}" {{ old('auteur_id', $livre->auteur_id) == $aut->id ? 'selected' : '' }}>{{ $aut->nom }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">ou</small>
            <input type="text" name="new_auteur" id="new_auteur" class="form-control mt-1" placeholder="Ajouter un nouvel auteur" value="{{ old('new_auteur') }}">
        </div>

        <div class="mb-3">
            <label for="annee" class="form-label">Année</label>
            <input type="number" name="annee" id="annee" class="form-control" value="{{ old('annee', $livre->annee) }}">
        </div>

        <div class="mb-3">
            <label for="nb_pages" class="form-label">Nombre de pages</label>
            <input type="number" name="nb_pages" id="nb_pages" class="form-control" value="{{ old('nb_pages', $livre->nb_pages) }}">
        </div>

        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" name="isbn" id="isbn" class="form-control" value="{{ old('isbn', $livre->isbn) }}">
        </div>

        <div class="mb-3">
            <label for="resume" class="form-label">Résumé</label>
            <textarea name="resume" id="resume" class="form-control" rows="4">{{ old('resume', $livre->resume) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="form-select">
                <option value="">-- Aucune --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('categorie_id', $livre->categorie_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="disponible" class="form-label">Disponible</label>
            <select name="disponible" id="disponible" class="form-select" required>
                <option value="1" {{ old('disponible', $livre->disponible) == '1' ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('disponible', $livre->disponible) == '0' ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.livres.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection