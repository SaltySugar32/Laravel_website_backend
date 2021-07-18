<?php

namespace Database\Factories;

use App\Models\Checklist;
use App\Models\Product;
use App\Models\ProductArticle;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ChecklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Checklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'purchase_id'=>function(){return Purchase::orderBy(DB::raw('RAND()'))->first()->id;},
            'product_article_id'=>function(){return ProductArticle::orderBy(DB::raw('RAND()'))->first()->id;},
            'purchase_amount'=>$this->faker->numberBetween(1,10),
        ];
    }
}
