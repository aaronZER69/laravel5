@extends('layouts.app', [
    'title' => 'Connexion',
    'breadcrumbs' => [
        ['label' => 'Accueil', 'url' => route('home')],
        ['label' => 'Connexion', 'url' => null]
    ]
])

@section('content')
<div class="container" style="max-width: 500px; margin-top: 50px;">
    <div class="card shadow">
        <div class="card-body p-5">
            <h2 class="text-center mb-4">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </button>
            </form>

            <hr class="my-4">

            <p class="text-center mb-0">
                Pas encore de compte ?
                <a href="{{ route('register') }}">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection
