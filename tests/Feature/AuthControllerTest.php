<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    

    public function test_login_redirects_to_dashboard_on_success()
    {
        
        $user = User::factory()->create([
            'email' => 'test10@example.com',
            'password' => bcrypt('password'),
        ]);

        
        $response = $this->post('/login', [
            'email' => 'test10@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }


    public function test_login_returns_error_on_invalid_credentials()
{
    // Create a user
    $user = User::factory()->create([
        'email' => 'test9@example.com',
        'password' => bcrypt('password'),
    ]);

    // Attempt to login with invalid credentials
    $response = $this->post('/login', [
        'email' => 'test9@example.com',
        'password' => 'wrongpassword',
    ]);

    // Assert that the response has validation errors
    $response->assertSessionHasErrors('email');

    // Assert that the user is not authenticated
    $this->assertGuest();
}


public function test_register_creates_user_and_redirects_to_profiles()
{
    // Data for registration
    $data = [
        'name' => 'John Doe',
        'email' => 'john10@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'monthly_income' => 5000,
    ];

    // Call the register method
    $response = $this->post('/register', $data);

    // Assert that the user is redirected to the profiles page
    $response->assertRedirect('/profiles');

    // Assert that the user was created in the database
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john10@example.com',
    ]);

    // Assert that the user is authenticated
    $this->assertAuthenticated();

    // Assert that the balance was created
    $user = User::where('email', 'john10@example.com')->first();
    $this->assertDatabaseHas('balances', [
        'user_id' => $user->id,
        'needs' => 5000 * 0.50,
        'wants' => 5000 * 0.30,
        'savings' => 5000 * 0.20,
    ]);

    // Assert that the profile was created
    $this->assertDatabaseHas('profiles', [
        'user_id' => $user->id,
        'name' => 'John Doe',
    ]);

    // Assert that the default categories were created
    $this->assertDatabaseHas('categories', [
        'user_id' => $user->id,
        'title' => 'rent',
    ]);
    $this->assertDatabaseHas('categories', [
        'user_id' => $user->id,
        'title' => 'travling',
    ]);
    $this->assertDatabaseHas('categories', [
        'user_id' => $user->id,
        'title' => 'Freelance',
    ]);
    $this->assertDatabaseHas('categories', [
        'user_id' => $user->id,
        'title' => 'goal',
    ]);
}






}