<?php

use App\Models\User;
use App\Models\UserProfile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

//um user tem apenas um user profile
test('Um usuário tem apenas um perfil de usuário', function () {
    // Cria um usuário
    $user = User::factory()->create();
    
    //cria um perfil de usuário associado ao usuário
    $profile = UserProfile::factory()->create(['user_id' => $user->id]);

    //testando a relação
    expect($user->profile)->not->toBeNull();
    expect($user->profile->phone)->toBe($profile->phone);
    expect($user->profile)->toBeInstanceOf(UserProfile::class);
});