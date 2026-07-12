<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('allows uploading a larger avatar image', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $file = UploadedFile::fake()->image('avatar.jpg', 1200, 1200)->size(3000);

    $response = $this->actingAs($user)->postJson('/profile/avatar', [
        'avatar' => $file,
    ]);

    $response->assertStatus(200)
        ->assertJsonPath('success', true);
});
