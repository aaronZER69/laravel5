@extends('layouts.app', [
    'title' => 'Gestion des livres',
    'breadcrumbs' => [
        ['label' => 'Accueil', 'url' => route('home')],
        ['label' => 'Administration', 'url' => route('admin.dashboard')],
        ['label' => 'Livres', 'url' => null],
    ],
])

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Livres</h2>
        <a href="{{ route('admin.livres.create') }}" class="btn btn-primary">Ajouter un livre</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Catégorie</th>
                <th>Année</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($livres as $livre)
                <tr>
                    <td>{{ $livre->id }}</td>
                    <td>{{ $livre->titre }}</td>
                    <td>{{ $livre->auteurRel?->nom ?? $livre->auteur }}</td>
                    <td>{{ $livre->categorie?->nom }}</td>
                    <td>{{ $livre->annee }}</td>
                    <td>
                        <form action="{{ route('admin.livres.destroy', $livre->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce livre ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $livres->links() }}
</div>
@endsection
