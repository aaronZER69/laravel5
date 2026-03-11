@extends('layouts.app', [
    'title' => 'Gestion des catégories',
    'breadcrumbs' => [
        ['label' => 'Accueil', 'url' => route('home')],
        ['label' => 'Administration', 'url' => route('admin.dashboard')],
        ['label' => 'Catégories', 'url' => null],
    ],
])

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Catégories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Ajouter une catégorie</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Livres</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $categorie)
                <tr>
                    <td>{{ $categorie->id }}</td>
                    <td>{{ $categorie->nom }}</td>
                    <td>{{ $categorie->description }}</td>
                    <td>{{ $categorie->livres()->count() }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ?{{ $categorie->livres()->count() > 0 ? ' Les livres associés seront supprimés également.' : '' }}');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection