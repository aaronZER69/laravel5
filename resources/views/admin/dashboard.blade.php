@extends('layouts.app', [
    'title' => 'Panneau admin',
    'breadcrumbs' => [
        ['label' => 'Accueil', 'url' => route('home')],
        ['label' => 'Administation', 'url' => null]
    ]
])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h2 class="mb-4">
                        <i class="fas fa-shield-alt"></i>
                        Panneau d'administration
                    </h2>

                    <div class="alert alert-warning">
                        <i class="fas fa-lock"></i>
                        <strong>Accès administrateur</strong> - Seuls les utilisateurs avec rôle <code>admin</code> peuvent voir cette page.
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <a href="{{ route('admin.users.index') }}" class="card text-decoration-none text-dark">
                                <div class="card-body text-center">
                                    <h3>
                                        <i class="fas fa-users" style="color: #0284C7;"></i>
                                    </h3>
                                    <h5>Utilisateurs</h5>
                                    <p class="lead">Gérer les utilisateurs</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('admin.livres.index') }}" class="card text-decoration-none text-dark">
                                <div class="card-body text-center">
                                    <h3>
                                        <i class="fas fa-book" style="color: #7C3AED;"></i>
                                    </h3>
                                    <h5>Livres</h5>
                                    <p class="lead">Gérer le catalogue</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h3>
                                        <i class="fas fa-book" style="color: #7C3AED;"></i>
                                    </h3>
                                    <h5>Livres</h5>
                                    <p class="lead">Gérer le catalogue</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h3>
                                        <i class="fas fa-list" style="color: #F59E0B;"></i>
                                    </h3>
                                    <h5>Catégories</h5>
                                    <p class="lead">Gérer les catégories</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            <h5>Informations système</h5>
                            <dl class="row">
                                <dt class="col-sm-3">Laravel :</dt>
                                <dd class="col-sm-9">{{ app()->version() }}</dd>

                                <dt class="col-sm-3">PHP :</dt>
                                <dd class="col-sm-9">{{ phpversion() }}</dd>

                                <dt class="col-sm-3">Base de données :</dt>
                                <dd class="col-sm-9">{{ config('database.default') }}</dd>
                            </dl>
                        </div>
                    </div>

                    <hr class="my-4">

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
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
