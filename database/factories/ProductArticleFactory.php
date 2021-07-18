<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductArticle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ProductArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductArticle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id'=>$this->faker->unique()->numberBetween(1,10),
            'title'=>$this->faker->words(3,true),
            'description'=>$this->faker->sentences(3,true),
            'short_description'=>$this->faker->sentence(6,true),
            'picture_link'=>$this->faker->imageUrl,
        ];
    }
}
