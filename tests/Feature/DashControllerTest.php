<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Categorie;
use App\Models\Transaction;
use App\Models\Goal;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class DashControllerTest extends TestCase
{
    public function test_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $profile = Profile::factory()->create(['user_id' => $user->id]);
    
        $response = $this->get(route('dashboard', ['id' => $profile->id]));
    
        $response->assertStatus(200);
    
        $response->assertViewIs('Userdashboard.dashboard');
    
        $response->assertViewHas(['categories', 'transactions', 'totalIncome', 'totalExpenses', 'proId', 'bala', 'needs', 'wants']);
    }


    public function test_deleteGoal()
{
    
    $user = User::factory()->create();
    $this->actingAs($user);

    $goal = Goal::factory()->create(['user_id' => $user->id]);

    
    $response = $this->delete(route('goals.delete', ['id' => $goal->id]));

    
    $this->assertDatabaseMissing('goals', ['id' => $goal->id]);

    
    $response->assertRedirect();
}

public function test_storeGoal()
{
    
    $user = User::factory()->create();
    $this->actingAs($user);

    
    $response = $this->post(route('goals.store'), [
        'title' => 'Test Goal',
        'target_amount' => 1000,
    ]);

    
    $this->assertDatabaseHas('goals', [
        'title' => 'Test Goal',
        'target_amount' => 1000,
        'user_id' => $user->id,
    ]);

    
    $response->assertRedirect();
}





public function test_Goals_displays()
{
    
    $user = User::factory()->create();
    $this->actingAs($user);

    
    $goal = Goal::factory()->create(['user_id' => $user->id]);

    
    $response = $this->get(route('goals'));

    
    $response->assertStatus(200);

    
    $response->assertViewIs('goals.goalsView');

    
    $response->assertViewHas(['goals', 'savings', 'pid', 'catg']);
}



public function test_storeTransaction()
{
    
    $user = User::factory()->create();
    $this->actingAs($user);

    
    $profile = Profile::factory()->create(['user_id' => $user->id]);
    $type = Type::factory()->create();

    
    $response = $this->post(route('transactions.store'), [
        'title' => 'Test Transaction',
        'amount' => 100,
        'type_id' => $type->id,
        'categorie_id' => null,
    ]);

    
    $this->assertDatabaseHas('transactions', [
        'title' => 'Test Transaction',
        'amount' => 100,
        'type_id' => $type->id,
        'profile_id' => $profile->id,
    ]);

    
    $response->assertRedirect();
}

public function test_DeleteCategory()
{
    
    $user = User::factory()->create();
    $this->actingAs($user);

    
    $category = Categorie::factory()->create(['user_id' => $user->id]);

    
    $response = $this->delete(route('categories.delete', ['id' => $category->id]));

    
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);

    
    $response->assertRedirect();
}


}
