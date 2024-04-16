<?php

namespace Tests\Feature;

use App\Models\ProductModel as Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public static function productDataProvider(): array
    {
        return [
            'valid_data' => [
                [
                    'title' => 'Valid title',
                    'description' => 'Valid description',
                    'price' => 100.00,
                ],
                Response::HTTP_CREATED,
            ],
            'empty_data' => [
                [
                    'title' => '',
                    'description' => '',
                    'price' => 0.00,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'without_title' => [
                [
                    'description' => 'Valid description',
                    'price' => 100.00,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'without_description' => [
                [
                    'title' => 'Valid title',
                    'price' => 100.00,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
            'without_price' => [
                [
                    'title' => 'Valid title',
                    'description' => 'Valid description',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            ],
        ];
    }

    #[test]
    #[DataProvider('productDataProvider')]
    public function itValidatesProductDataDuringCreation(array $data, int $expectedStatus): void
    {
        $response = $this->postJson(route('product.create'), $data);

        $response->assertStatus($expectedStatus);
    }

    #[test]
    #[DataProvider('productDataProvider')]
    public function itValidatesProductDataDuringUpdate(array $data, int $expectedStatus): void
    {
        $product = Product::factory()->create();

        $response = $this->putJson(route('product.update', $product->id), $data);

        if ($expectedStatus == Response::HTTP_CREATED) {
            $expectedStatus = Response::HTTP_OK;
        }

        $response->assertStatus($expectedStatus);
    }

    #[test]
    public function itCanListAllProducts(): void
    {
        $numOfRegisters = 5;
        Product::factory()->count($numOfRegisters)->create();

        $response = $this->getJson(route('product.list'));

        $response->assertSee(['id', 'title', 'description', 'price']);
        $response->assertOk()
            ->assertJsonCount($numOfRegisters);
    }

    #[test]
    public function itCanReadAProduct(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('product.read', $product->id));

        $response->assertSee(['id', 'title', 'description', 'price']);
        $response->assertOk();
    }

    #[test]
    public function itCantReadAInexistentProduct(): void
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('product.read', $product->id + 1));

        $response->assertSee(['error']);
        $response->assertUnprocessable();
    }

    #[test]
    public function itCanDeleteAProduct(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('product.delete', $product));

        $response->assertOk();
        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $response->assertSee(['id', 'title', 'description', 'price']);
    }
}
