<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Storage;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
        return [
            'storage_id'=>function(){return Storage::orderBy(DB::raw('RAND()'))->first()->id;}
            ];
    }
}
