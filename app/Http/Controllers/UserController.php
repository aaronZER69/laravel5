<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Gestion basique des utilisateurs pour l'administrateur.
 * Toutes les routes sont protégées par le middleware `role:admin`.
 */
class UserController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs (paginated).
     *
     * ⚠️ Middleware `auth` + `role:admin` appliqué via les routes.
     */
    public function index()
    {
        $users = User::paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // méthodes supplémentaires (show, delete, updateRole) peuvent être ajoutées plus tard
}
