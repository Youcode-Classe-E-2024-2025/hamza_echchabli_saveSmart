<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;

class ProfileControllerTest extends TestCase
{
    
    

    public function createsProfile()
    {

        $user = User::factory()->create();
        $this->actingAs($user);
    
        
        $file = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg');
    
        
        $response = $this->post('/profiles', [
            'name' => 'John Doe',
            'avatar' => $file,
        ]);
    
        
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'name' => 'John Doe',
        ]);
    
        
        $response->assertRedirect('/profiles');
    }
   

}
