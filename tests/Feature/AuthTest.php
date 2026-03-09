<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $response->assertRedirect('/dashboard');
    }

    public function test_user_can_login()
    {
        $user = User::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_view_users()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/utilisateurs');
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    /**
     * Admin peut gérer la liste des livres (consultation, ajout, suppression)
     */
    public function test_admin_can_manage_books()
    {
        $admin = User::create([
            'name' => 'Admin2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // ensure at least one author for the dropdown
        \App\Models\Auteur::firstOrCreate(['nom' => 'DropdownAuthor']);

        // voir la liste vide
        $response = $this->actingAs($admin)->get('/admin/livres');
        $response->assertStatus(200)->assertViewIs('admin.livres.index');

        // création formulaire propose les auteurs existants
        $response = $this->actingAs($admin)->get('/admin/livres/create');
        $response->assertStatus(200);
        $response->assertSee('DropdownAuthor');

        // ajouter une catégorie (nécessaire)
        $cat = \App\Models\Categorie::create(['nom' => 'Test', 'slug' => 'test', 'couleur' => '#000', 'icone' => 'fas fa-book']);

        // créer un livre via POST en utilisant un nouvel auteur
        $response = $this->actingAs($admin)->post('/admin/livres', [
            'titre' => 'Foo',
            'new_auteur' => 'Bar',
            'annee' => 2020,
            'disponible' => true,
            'categorie_id' => $cat->id,
        ]);
        $response->assertRedirect('/admin/livres');
        $this->assertDatabaseHas('livres', ['titre' => 'Foo']);

        $livre = \App\Models\Livre::where('titre','Foo')->first();

        // suppression
        $response = $this->actingAs($admin)->delete('/admin/livres/' . $livre->id);
        $response->assertRedirect('/admin/livres');
        $this->assertDatabaseMissing('livres', ['id' => $livre->id]);
    }
}