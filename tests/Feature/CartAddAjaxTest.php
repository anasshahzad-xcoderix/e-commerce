<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAddAjaxTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_adds_a_product_to_the_cart_and_returns_json(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Test Mug',
            'price' => 25,
            'art' => 'mug',
            'stock' => 5,
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->postJson(route('cart.add'), ['product_id' => $product->id]);

        $response->assertOk()->assertJson([
            'success' => true,
            'message' => 'Test Mug added to cart.',
            'count' => 1,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    public function test_it_returns_json_without_adding_a_duplicate_product(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Test Mug',
            'price' => 25,
            'art' => 'mug',
            'stock' => 5,
        ]);

        $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->postJson(route('cart.add'), ['product_id' => $product->id])
            ->assertOk()
            ->assertJson(['success' => true, 'count' => 1]);

        $response = $this->postJson(route('cart.add'), ['product_id' => $product->id]);

        $response->assertOk()->assertJson([
            'success' => false,
            'message' => 'Test Mug is already in your cart.',
            'count' => 1,
        ]);

        $this->assertSame(1, CartItem::count());
    }

    public function test_it_requires_a_valid_product_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('cart.add'));

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('product_id');

        $this->assertSame(0, CartItem::count());
    }
}
