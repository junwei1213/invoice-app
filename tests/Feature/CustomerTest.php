<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_customers_page()
    {
        $response = $this->get('/customers');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_customers_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/customers');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_customer()
    {
        $user = User::factory()->create();
        $customerData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'is_deleted' => '0',
        ];

        $response = $this->actingAs($user)->post('/customers', $customerData);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'is_deleted' => 0, // default value
        ]);

        $response->assertRedirect(route('invoices.create'));
    }

    public function test_authenticated_user_can_soft_delete_customer()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->delete(route('customers.destroy', $customer->id));

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'is_deleted' => 1,
        ]);

        $response->assertRedirect(route('customers.index'));
    }
}
