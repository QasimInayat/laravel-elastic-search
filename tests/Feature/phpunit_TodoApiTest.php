<?php

// namespace Tests\Feature;

// use Tests\TestCase;
// use App\Models\User;
// use App\Models\Todo;
// use Laravel\Sanctum\Sanctum;
// use Illuminate\Foundation\Testing\RefreshDatabase;

// class TodoApiTest extends TestCase
// {
//     use RefreshDatabase;

//     private function createUser()
//     {
//         return User::create([
//             'name' => 'Test User',
//             'email' => uniqid().'@example.com',
//             'password' => bcrypt('password'),
//         ]);
//     }

//     /** @test */
//     public function guest_cannot_access_todos()
//     {
//         $response = $this->getJson('/api/todos');
//         $response->assertStatus(401);
//     }

//     /** @test */
//     public function authenticated_user_can_create_todo()
//     {
//         $user = $this->createUser();
//         Sanctum::actingAs($user);

//         $response = $this->postJson('/api/todos', [
//             'title' => 'My First Todo',
//         ]);

//         $response->assertStatus(201)
//                  ->assertJsonFragment(['title' => 'My First Todo']);

//         $this->assertDatabaseHas('todos', [
//             'title' => 'My First Todo',
//             'user_id' => $user->id,
//         ]);
//     }

//     /** @test */
//     public function it_requires_title_to_create_todo()
//     {
//         $user = $this->createUser();
//         Sanctum::actingAs($user);

//         $response = $this->postJson('/api/todos', []);

//         $response->assertStatus(422);
//         $response->assertJsonValidationErrors(['title']);
//     }

//     /** @test */
//     public function authenticated_user_sees_only_their_todos()
//     {
//         $user1 = $this->createUser();
//         $user2 = $this->createUser();

//         // Create todos manually (no factories)
//         Todo::create(['title' => 'User1 Todo', 'user_id' => $user1->id]);
//         Todo::create(['title' => 'User2 Todo', 'user_id' => $user2->id]);

//         Sanctum::actingAs($user1);
//         $response = $this->getJson('/api/todos');

//         $response->assertStatus(200);
//         $response->assertJsonFragment(['title' => 'User1 Todo']);
//         $response->assertJsonMissing(['title' => 'User2 Todo']);
//     }
// }
