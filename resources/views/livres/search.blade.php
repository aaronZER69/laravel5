@extends('layouts.app', [
    'title' => 'Recherche de livres',
    'breadcrumbs' => [
    ['label' => 'Catalogue', 'url' => route('livres.index')],
    ['label' => 'Recherche', 'url' => null]
    ]
])

@section('content')
<div class="container">
    {{-- Formulaire de recherche --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2><i class="fas fa-search"></i> Recherche de Livres</h2>
                    <form action="{{ route('livres.search') }}" method="GET" class="mt-3">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control form-control-lg" 
                                   placeholder="Rechercher par titre, auteur ou catégorie..."
                                   value="{{ $query }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Rechercher
                            </button>
                        </div>
                        @if($query)
                        <div class="mt-2">
                            <a href="{{ route('livres.search') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times"></i> Effacer la recherche
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Résultats --}}
    @if($query)
    <div class="row mb-4">
        <div class="col-12">
                <h3>
                Résultats pour "{{ $query }}"
                <span class="badge bg-secondary">{{ $total }}</span>
                </h3>

                @if($total > 0)
                    <div class="list-group mt-3">
                        @foreach($livres as $livre)
                            <a href="{{ route('livres.show', $livre->id) }}" class="list-group-item list-group-item-action">
                                <strong>{{ $livre->titre }}</strong>
                                <div class="small text-muted">{{ $livre->auteur }} @if($livre->categorie) — {{ $livre->categorie->nom }} @endif</div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info mt-3">Aucun résultat trouvé.</div>
                @endif

            </div>
        </div>
    </div>
    @endif
</div>
@endsection