<?php

namespace Tests\Feature;

use App\Enums\CacheKeysEnum;
use App\Models\ProductModel as Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
                true,
            ],
            'empty_data' => [
                [
                    'title' => '',
                    'description' => '',
                    'price' => 0.00,
                ],
                false,
            ],
            'without_title' => [
                [
                    'description' => 'Valid description',
                    'price' => 100.00,
                ],
                false,
            ],
            'without_description' => [
                [
                    'title' => 'Valid title',
                    'price' => 100.00,
                ],
                false,
            ],
            'without_price' => [
                [
                    'title' => 'Valid title',
                    'description' => 'Valid description',
                ],
                false,
            ],
        ];
    }

    #[test]
    #[DataProvider('productDataProvider')]
    public function itValidatesProductDataDuringCreation(array $payload, bool $shouldBeSuccess): void
    {
        //act
        $response = $this->postJson(route('product.create'), $payload);

        //ass
        if ($shouldBeSuccess) {
            $response->assertCreated();
        }else {
            $response->assertUnprocessable();
        }
    }

    #[test]
    #[DataProvider('productDataProvider')]
    public function itValidatesProductDataDuringUpdate(array $payload, bool $shouldBeSuccess): void
    {
        //arr
        $product = Product::factory()->create();

        //act
        $response = $this->putJson(route('product.update', $product->id), $payload);

        //ass
        if ($shouldBeSuccess) {
            $response->assertOk();
        }else {
            $response->assertUnprocessable();
        }
    }

    #[test]
    public function itProductUpdateCleanCaches(): void
    {
        //arr
        $product = Product::factory()->create();
        $productNew = Product::factory()->make();

        $cacheKeyRead = CacheKeysEnum::PRODUCTS_FIND_ID->valueWith([$product->id]);
        $cacheKeyList = CacheKeysEnum::PRODUCTS_ALL->value;

        //act
        cache()->put($cacheKeyRead, 1);
        cache()->put($cacheKeyList, 1);
        
        $this->putJson(route('product.update', $product->id), $productNew->toArray());
        $cacheAfterRequest = cache()->get($cacheKeyRead);
        $cacheAfterRequestList = cache()->get($cacheKeyList);

        //ass
        $this->assertNull($cacheAfterRequest);
        $this->assertNull($cacheAfterRequestList);
    }

    #[test]
    public function itCanListAllProducts(): void
    {
        //arr
        $numOfRegisters = 5;
        Product::factory()->count($numOfRegisters)->create();

        //act
        $response = $this->getJson(route('product.list'));

        //ass
        $response->assertSee(['id', 'title', 'description', 'price']);
        $response->assertOk()
            ->assertJsonCount($numOfRegisters);
    }

    #[test]
    public function itCanListAllProductsFromCache(): void
    {
        //arr
        $numOfRegisters = 5;
        Product::factory()->count($numOfRegisters)->create();
        $cacheKey = CacheKeysEnum::PRODUCTS_ALL->value;

        //act
        $cacheBeforeRequest = cache()->has($cacheKey);
        $response = $this->getJson(route('product.list'));
        $cacheAfterRequest = cache()->has($cacheKey);
        $cachedData = cache()->get($cacheKey);

        //ass
        $this->assertFalse($cacheBeforeRequest);
        $this->assertTrue($cacheAfterRequest);
        $response->assertJson($cachedData);
    }

    #[test]
    public function itCanReadAProduct(): void
    {
        //arr
        $product = Product::factory()->create();

        //act
        $response = $this->getJson(route('product.read', $product->id));

        //ass
        $response->assertSee(['id', 'title', 'description', 'price']);
        $response->assertOk();
    }

    #[test]
    public function itCanReadAProductFromCache(): void
    {
        //arr
        $product = Product::factory()->create();
        $cacheKey = CacheKeysEnum::PRODUCTS_FIND_ID->valueWith([$product->id]);

        //act
        $cacheBeforeRequest = cache()->has($cacheKey);
        $response = $this->getJson(route('product.read', $product->id));
        $cacheAfterRequest = cache()->has($cacheKey);
        $cachedData = cache()->get($cacheKey);

        //ass
        $this->assertFalse($cacheBeforeRequest);
        $this->assertTrue($cacheAfterRequest);
        $response->assertJson($cachedData);
    }

    #[test]
    public function itCantReadAInexistentProduct(): void
    {
        //arr
        $product = Product::factory()->create();

        //act
        $response = $this->getJson(route('product.read', $product->id + 1));

        //ass
        $response->assertSee(['error']);
        $response->assertUnprocessable();
    }

    #[test]
    public function itCanDeleteAProduct(): void
    {
        //arr
        $product = Product::factory()->create();

        //act
        $response = $this->deleteJson(route('product.delete', $product->id));

        //ass
        $response->assertOk();
        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $response->assertSee(['id', 'title', 'description', 'price']);
    }
}

