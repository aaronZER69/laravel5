@extends('layouts.app', [
    'title' => 'Ajouter une catégorie',
    'breadcrumbs' => [
        ['label' => 'Accueil', 'url' => route('home')],
        ['label' => 'Administration', 'url' => route('admin.dashboard')],
        ['label' => 'Catégories', 'url' => route('admin.categories.index')],
        ['label' => 'Ajouter', 'url' => null],
    ],
])

@section('content')
<div class="container">
    <h2>Ajouter une catégorie</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection