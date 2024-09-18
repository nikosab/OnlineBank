<?php

use App\Models\Account;
use App\Models\User;

test('redirects from the dashboard route if unauthorized', function () {
    $response = $this->get('/dashboard');

    $response->assertStatus(302);
});

test('returns a successful response from the dashboard route', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/dashboard');

    $response->assertStatus(200);
});

test('returns a successful response from the accounts route', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/accounts');

    $response->assertStatus(200);
});

test('returns a successful response from the transaction route', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/transactions');

    $response->assertStatus(200);
});
