<?php

use App\Enums\GenderEnum;
use App\Models\Staff;

use function Pest\Laravel\actingAs;

test('profile page is displayed', function () {
    $user = Staff::factory()->create();

    $response = actingAs($user)
        ->getJson(route('user.profile.edit'));

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = Staff::factory()->create();

    $response = actingAs($user)
        ->putJson(route('user.profile.update'), [
            'name' => 'Test User',
            'gender' => GenderEnum::MALE->value,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('user.profile.edit'));

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame(GenderEnum::MALE, $user->gender);
});
