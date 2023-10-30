<?php

use App\Models\Landlord\TenantSignupDescription;

beforeEach(function () {
    $this->userAuthenticated();
});


it('gives back a successful response for the page', function () {
    // $this->withoutExceptionHandling();
    $this->get(route('tenantSignupDescription.index'))->assertOk();
});

it('returns correct view', function() {
    // Act & Assert
    $this->get(route('tenantSignupDescription.index'))
        ->assertOk()
        ->assertViewIs('landlord.super-admin.pages.tenant-signup-descriptions.index');
});


/*
|--------------------------------------------------------------------------
| Validation During Store
|--------------------------------------------------------------------------
|
*/


test('heading - required | string | min:3 | max: 50', function () {
    // $this->withoutExceptionHandling();
    TenantSignupDescription::factory()->create();

    $this->post(route('tenantSignupDescription.updateOrCreate'), array_merge(TenantSignupDescriptionData(), ['heading' =>'']))
        ->assertInvalid(['heading' => 'required']);

    $this->post(route('tenantSignupDescription.updateOrCreate'), array_merge(TenantSignupDescriptionData(), ['heading' => 12]))
        ->assertSessionHasErrors('heading');

    $this->post(route('tenantSignupDescription.updateOrCreate'), array_merge(TenantSignupDescriptionData(), ['heading' => 'ab']))
        ->assertSessionHasErrors('heading');

    $this->post(route('tenantSignupDescription.updateOrCreate'), array_merge(TenantSignupDescriptionData(), ['heading' => 'fdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfdfdsffdffdsfdsfdsfdsfdsfdsfdsfdsfdsfdsfdsffdfytrythghfgdhfghgfhfghfgnhgnnnbv fgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdfgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgfdgdgfd']))
        ->assertSessionHasErrors('heading');
});

test('sub_heading - required|string|min:3', function () {
    // $this->withoutExceptionHandling();
    TenantSignupDescription::factory()->create();

    $this->post(route('tenantSignupDescription.updateOrCreate'), array_merge(TenantSignupDescriptionData(), ['sub_heading' =>'']))
        ->assertInvalid(['sub_heading' => 'required']);

    $this->post(route('tenantSignupDescription.updateOrCreate'), array_merge(TenantSignupDescriptionData(), ['sub_heading' => 12]))
        ->assertSessionHasErrors('sub_heading');

    $this->post(route('tenantSignupDescription.updateOrCreate'), array_merge(TenantSignupDescriptionData(), ['sub_heading' => 'ab']))
        ->assertSessionHasErrors('sub_heading');
});

/*
|--------------------------------------------------------------------------
| Update or Store
|--------------------------------------------------------------------------
|
*/

test('TenantSignupDescription Store', function () {
    $this->withoutExceptionHandling();
    $this->post(route('tenantSignupDescription.updateOrCreate'), TenantSignupDescriptionData());
    $this->assertCount(1, TenantSignupDescription::all());
});

