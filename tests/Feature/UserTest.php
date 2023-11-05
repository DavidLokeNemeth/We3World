<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_registration()
    {
        //Try create new user
        $response = $this->postJson('/api/register', [
            'name' => 'Sally',
            'email' => 'asdf@sdafa.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        //Check successful creation
        $response->assertStatus(201)
            ->assertJsonPath('user.name', 'Sally')
            ->assertJsonPath('user.email', 'asdf@sdafa.com');

        //Remove (if we not remove, a) db start to be too big b) can't reuse this email
        User::destroy($response->decodeResponseJson()['user']['id']);
    }

    public function test_user_registration_wrong_email()
    {
        //Try create new user
        $response = $this->postJson('/api/register', [
            'name' => 'Sally',
            'email' => 'asdfsdafacom',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The email must be a valid email address.');
    }

    public function test_user_registration_missing_name()
    {
        //Try create new user
        $response = $this->postJson('/api/register', [
            'email' => 'asdfs@dafa.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The name field is required.');
    }

    public function test_user_registration_missing_email()
    {
        //Try create new user
        $response = $this->postJson('/api/register', [
            'name' => 'Sally',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The email field is required.');
    }

    public function test_user_registration_missing_password()
    {
        //Try create new user
        $response = $this->postJson('/api/register', [
            'name' => 'Sally',
            'email' => 'asdfs@dafa.com',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The password field is required.');
    }

    public function test_user_registration_missing_password_conformation()
    {
        //Try create new user
        $response = $this->postJson('/api/register', [
            'name' => 'Sally',
            'email' => 'asdfs@dafa.com',
            'password' => '1234',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The password confirmation does not match.');
    }

    public function test_user_registration_wrong_password_conformation()
    {
        //Try create new user
        $response = $this->postJson('/api/register', [
            'name' => 'Sally',
            'email' => 'asdfs@dafa.com',
            'password' => '1234',
            'password_confirmation' => '12345',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The password confirmation does not match.');
    }

    public function test_user_login()
    {
        //Create user
        $user = User::factory()->create(['password' => bcrypt('1234')]);

        //Check login
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '1234',
        ]);

        //Check answer
        $response->assertStatus(201)
            ->assertJsonStructure([
               'token',
            ]);

        //Destroy user
        User::destroy($user->id);
    }

    public function test_user_login_missing_email()
    {
        //Create user
        $user = User::factory()->create(['password' => bcrypt('1234')]);

        //Check login
        $response = $this->postJson('/api/login', [
            'password' => '1234',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The email field is required.');

        //Destroy user
        User::destroy($user->id);
    }

    public function test_user_login_wrong_email()
    {
        //Check login
        $response = $this->postJson('/api/login', [
            'email' => 'notexist@email.test',
            'password' => '123445',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'User not find with this email');
    }

    public function test_user_login_missing_password()
    {
        //Create user
        $user = User::factory()->create(['password' => bcrypt('1234')]);

        //Check login
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'The password field is required.');

        //Destroy user
        User::destroy($user->id);
    }

    public function test_user_login_wrong_password()
    {
        //Create user
        $user = User::factory()->create(['password' => bcrypt('1234')]);

        //Check login
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123445',
        ]);

        //Check answer
        $response->assertStatus(422)
            ->assertJsonPath('message', 'Incorrect password');

        //Destroy user
        User::destroy($user->id);
    }
}
