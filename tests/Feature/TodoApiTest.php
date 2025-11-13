<?php

use App\Models\User;
use App\Models\Todo;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can create todo', function () {
    $user = User::create([
        'name' => 'Test User',
        'email' => uniqid() . '@example.com',
        'password' => bcrypt('password'),
    ]);

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/todos', [
        'title' => 'New Todo',
    ]);

    $response->assertStatus(201)
        ->assertJsonFragment(['title' => 'New Todo']);

    $this->assertDatabaseHas('todos', [
        'title' => 'New Todo',
        'user_id' => $user->id,
    ]);
});
