<?php

use App\Enums\GenderEnum;
use App\Models\Staff;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\assertSoftDeleted;

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

test('user can delete their account', function () {
    $user = Staff::factory()->create();

    actingAs($user)
        ->delete(route('user.profile.destroy'), [
            'password' => 'password',
        ])->assertSessionHasNoErrors()
        ->assertRedirect(route('login'));

    assertGuest();
    assertSoftDeleted($user);
});

test('correct password must be provided to delete account', function () {
    $user = Staff::factory()->create();

    $response = actingAs($user)
        ->fromRoute('user.profile.edit')
        ->delete(route('user.profile.destroy'), [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('password')
        ->assertRedirect(route('user.profile.edit'));

    $this->assertNotNull($user->fresh());
});
