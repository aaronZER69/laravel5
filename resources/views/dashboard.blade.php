@extends('layouts.app', [
    'title' => 'Tableau de bord',
    'breadcrumbs' => [
        ['label' => 'Accueil', 'url' => route('home')],
        ['label' => 'Tableau de bord', 'url' => null]
    ]
])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h2 class="mb-3">
                        <i class="fas fa-tachometer-alt"></i>
                        Bienvenue, {{ auth()->user()->name }}!
                    </h2>
                    
                    <div class="alert alert-info">
                        <strong>Votre rôle :</strong> 
                        <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Actions rapides</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="{{ route('livres.index') }}">
                                        <i class="fas fa-book"></i> Voir le catalogue
                                    </a>
                                </li>
                                @if(auth()->user()->isAdmin())
                                <li class="list-group-item">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog"></i> Administrer
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h5>Informations du compte</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Email :</dt>
                                <dd class="col-sm-7">{{ auth()->user()->email }}</dd>

                                <dt class="col-sm-5">Membre depuis :</dt>
                                <dd class="col-sm-7">{{ auth()->user()->created_at->format('d/m/Y') }}</dd>
                            </dl>
                        </div>
                    </div>

                    <hr class="my-4">

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
