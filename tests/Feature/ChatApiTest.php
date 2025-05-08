<?php
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\Conversation;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Http;

test('authenticated user can access chat route and get AI reply', function () {
    // Mock the DeepInfra API for AI reply
    Http::fake([
        'https://api.deepinfra.com/*' => Http::response([
            'choices' => [
                [
                    'message' => ['content' => 'This is a mock AI response.']
                ]
            ]
        ])
    ]);

    // Create and authenticate user
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    // Simulate sending a new message
    $response = $this->postJson('/api/chat', [
        'message' => 'Hello, AI!',
        'conversation_id' => '', // empty means new conversation
    ]);

    // Check if the response is OK
    $response->assertStatus(200)
        ->assertJsonStructure([
            'reply',
            'conversation_id',
        ]);

    // Check DB entries
    $this->assertDatabaseHas('conversations', [
        'user_id' => $user->id,
    ]);

    $this->assertDatabaseHas('chat_messages', [
        'user_id' => $user->id,
        'user_prompt' => 'Hello, AI!',
        'ai_reply' => 'This is a mock AI response.',
    ]);
});

test('unauthenticated user cannot access chat route', function () {
    // Simulate sending a new message without authentication
    $response = $this->postJson('/api/chat', [
        'message' => 'Hello, AI!',
        'conversation_id' => '',
    ]);

    // Check that unauthenticated users receive a 401 Unauthorized response
    $response->assertStatus(401);
});

test('authenticated user can access chat conversations', function () {
    // Create and authenticate user
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    // Create a conversation for the user
    $conversation = Conversation::create([
        'user_id' => $user->id,
        'title' => 'Test Conversation',
    ]);
    $conversation->save();

    // Simulate fetching chat conversations
    $response = $this->getJson('/api/chat/conversations');

    // Check if the response is OK and contains the expected conversation structure
    $response->assertStatus(200)
        ->assertJsonStructure([
            'conversations' => [
                '*' => ['id', 'title', 'user_id', 'created_at', 'updated_at'],
            ],
        ]);
});

test('unauthenticated user cannot access chat conversations', function () {
    // Simulate fetching chat conversations without authentication
    $response = $this->getJson('/api/chat/conversations');

    // Check that unauthenticated users receive a 401 Unauthorized response
    $response->assertStatus(401);
});

test('authenticated user can access chat messages', function () {
    // Create and authenticate user
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    // // Create a conversation and some chat messages for the user
    // $conversation = Conversation::factory()->create(['user_id' => $user->id]);
    // ChatMessage::factory()->create(['conversation_id' => $conversation->id, 'user_id' => $user->id]);

    // Manually create a conversation for the authenticated user
    $conversation = Conversation::create([
        'user_id' => $user->id,  // Associate it with the authenticated user
        'title' => 'Test Conversation Title', // Manually set the title
    ]);

    // Manually create chat messages for this conversation
    $chatMessage = ChatMessage::create([
        'user_id' => $user->id,
        'conversation_id' => $conversation->id,
        'user_prompt' => 'This is a test user prompt.',
        'ai_reply' => 'This is a test AI reply.',
    ]);

    // Simulate fetching chat messages for the user
    $response = $this->getJson("/api/chat/messages");

    // Check if the response is OK
    $response->assertStatus(200)
        ->assertJsonStructure([
            // '*' => ['user_prompt', 'ai_reply', 'created_at'],
            // 'messages' => $chatMessage,
            'messages' => [
                '*' => [  // This will match each item in the 'messages' array
                    'id',
                    'user_id',
                    'conversation_id',
                    'user_prompt',
                    'ai_reply',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
});

test('unauthenticated user cannot access chat messages', function () {
    // Simulate fetching chat messages without authentication
    $response = $this->getJson('/api/chat/messages');

    // Check that unauthenticated users receive a 401 Unauthorized response
    $response->assertStatus(401);
});