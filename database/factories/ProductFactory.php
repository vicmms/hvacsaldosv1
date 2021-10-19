<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $name = $this->faker->sentence(2);
        $model = $this->faker->sentence(3);

        $subcategory = Subcategory::all()->random();
        $category = Category::all()->random();

        $brand = Brand::all()->random();

        if ($subcategory->color) {
            $quantity = null;
        } else {
            $quantity = 15;
        }

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomElement([19.99, 49.99, 99.99]),
            'commercial_price' => $this->faker->randomElement([29.99, 59.99, 119.99]),
            'subcategory_id' => $subcategory->id,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'quantity' => $quantity,
            'status' => 2,
            'model' => $model,
            'shipping' => $this->faker->randomElement([0, 1]),
            'shipping_cost' => $this->faker->randomElement([20, 100, 400]),
            'serie_number' => $this->faker->sentence(3),
            'state_id' => 1,
            'user_id' => 1,


        ];
    }
}
