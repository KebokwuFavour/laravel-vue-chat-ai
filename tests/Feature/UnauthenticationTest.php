<?php

use App\Models\User;

test('authenticated users can unauthenticate using the logout screen', function () {
  // Create a user instance
  // This user will be used to simulate a logged-in state
  $user = User::factory()->create();

  // Simulate the user being logged in
  $this->actingAs($user);

  // Perform the logout POST request
  $response = $this->post('/logout');

  // Assert the user is redirected after logout
  $response->assertRedirect('/');
});