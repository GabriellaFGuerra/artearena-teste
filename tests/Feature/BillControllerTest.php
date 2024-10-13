<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_bills()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get('/bills');
        $response->assertStatus(200);
    }

    public function test_non_admin_can_view_own_bills()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get('/bills');
        $response->assertStatus(200);
    }

    public function test_create_view_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/bills/create');
        $response->assertStatus(200);
    }

    public function test_store_bill_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/bills', [
            'title' => 'Test Bill',
            'description' => 'Test Description',
            'amount' => 100,
            'due_date' => '2023-12-31',
            'user_id' => $user->id,
        ]);

        $response->assertRedirect('/bills');
        $this->assertDatabaseHas('bills', ['title' => 'Test Bill']);
    }

    public function test_store_bill_validation_errors()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/bills', [
            'title' => '',
            'description' => '',
            'amount' => -100,
            'due_date' => 'invalid-date',
            'user_id' => 999,
        ]);

        $response->assertSessionHasErrors(['title', 'description', 'amount', 'due_date', 'user_id']);
    }

    public function test_edit_view_can_be_rendered()
    {
        $user = User::factory()->create();
        $bill = Bill::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get("/bills/{$bill->id}/edit");
        $response->assertStatus(200);
    }

    public function test_update_bill_successfully()
    {
        $user = User::factory()->create();
        $bill = Bill::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put("/bills/{$bill->id}", [
            'title' => 'Updated Bill',
            'description' => 'Updated Description',
            'amount' => 200,
            'due_date' => '2023-12-31',
            'status' => 'paid',
        ]);

        $response->assertRedirect('/bills');
        $this->assertDatabaseHas('bills', ['title' => 'Updated Bill']);
    }

    public function test_update_bill_validation_errors()
    {
        $user = User::factory()->create();
        $bill = Bill::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put("/bills/{$bill->id}", [
            'title' => '',
            'description' => '',
            'amount' => -200,
            'due_date' => 'invalid-date',
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors(['title', 'description', 'amount', 'due_date', 'status']);
    }

    public function test_unauthorized_update_attempt()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $bill = Bill::factory()->create(['user_id' => $anotherUser->id]);
        $this->actingAs($user);

        $response = $this->put("/bills/{$bill->id}", [
            'title' => 'Updated Bill',
            'description' => 'Updated Description',
            'amount' => 200,
            'due_date' => '2023-12-31',
            'status' => 'paid',
        ]);

        $response->assertRedirect('/bills');
        $response->assertSessionHas('error', 'Você não tem permissão para isto.');
    }

    public function test_destroy_bill_successfully()
    {
        $user = User::factory()->create();
        $bill = Bill::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete("/bills/{$bill->id}");
        $response->assertRedirect('/bills');
        $this->assertDatabaseMissing('bills', ['id' => $bill->id]);
    }

    public function test_unauthorized_delete_attempt()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $bill = Bill::factory()->create(['user_id' => $anotherUser->id]);
        $this->actingAs($user);

        $response = $this->delete("/bills/{$bill->id}");
        $response->assertRedirect('/bills');
        $response->assertSessionHas('error', 'Você não tem permissão para isto.');
    }
}