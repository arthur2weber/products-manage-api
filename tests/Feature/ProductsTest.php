<?php

namespace Tests\Feature;

use App\Models\ProductModel as Product;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    private $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    #[Test]
    public function it_can_list_all_products(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson(route('api.products.list'));

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function productDataProvider()
    {
        return [
            'empty_data' => [
                [
                    'title' => $this->faker->sentence(3),
                    'description' => $this->faker->paragraph(),
                    'price' => $this->faker->randomFloat(2, 0, 100),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'invalid_data' => [
                [
                    'title' => $this->faker->sentence(3),
                    'description' => $this->faker->paragraph(),
                    'price' => $this->faker->randomFloat(-10, -0.01),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'valid_data' => [
                [
                    'title' => $this->faker->sentence(3),
                    'description' => $this->faker->paragraph(),
                    'price' => $this->faker->randomFloat(2, 0, 100),
                ],
                Response::HTTP_CREATED,
            ],
            'without_title' => [
                [
                    'description' => $this->faker->paragraph(),
                    'price' => $this->faker->randomFloat(2, 0, 100),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'without_description' => [
                [
                    'title' => $this->faker->sentence(3),
                    'price' => $this->faker->randomFloat(2, 0, 100),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'without_price' => [
                [
                    'title' => $this->faker->sentence(3),
                    'description' => $this->faker->paragraph(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
        ];
    }

    #[Test]
    #[DataProvider('productDataProvider')]
    public function it_validates_product_data_during_creation(array $data, int $expectedStatus): void
    {
        $response = $this->postJson(route('api.products.create'), $data);

        $response->assertStatus($expectedStatus)
            ->assertJsonValidationErrors(
                $expectedStatus === Response::HTTP_UNPROCESSABLE_ENTITY ? ['title', 'description', 'price'] : []
            );
    }

    #[Test]
    #[DataProvider('productDataProvider')]
    public function it_validates_product_data_during_update(array $data, int $expectedStatus): void
    {
        $product = Product::factory()->create();

        $response = $this->putJson(route('api.products.update', $product), $data);

        $response->assertStatus($expectedStatus)
            ->assertJsonValidationErrors(
                $expectedStatus === Response::HTTP_UNPROCESSABLE_ENTITY ? ['title', 'description', 'price'] : []
            );
    }

    #[Test]
    public function it_can_delete_a_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.products.delete', $product));

        $response->assertNoContent();

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
