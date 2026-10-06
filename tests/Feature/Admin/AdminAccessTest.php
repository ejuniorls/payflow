<?php

use App\Models\Role;
use App\Models\User;

test('visitantes são redirecionados para o login', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

test('usuários sem o papel admin recebem 403', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('administradores acessam o painel', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.dashboard'))
        ->assertOk();
});

test('o link do admin aparece só para administradores', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('dashboard'))
        ->assertDontSee(route('admin.dashboard'));

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('dashboard'))
        ->assertSee(route('admin.dashboard'));
});

test('excluir o papel admin revoga o acesso', function () {
    $user = User::factory()->admin()->create();

    Role::where('name', 'admin')->firstOrFail()->delete();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});
