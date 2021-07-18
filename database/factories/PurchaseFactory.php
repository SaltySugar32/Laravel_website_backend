<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_profile_id'=>function(){return UserProfile::orderBy(DB::raw('RAND()'))->first()->id;},
            'total_price'=>$this->faker->randomFloat(2,10,100000),
            ];
    }
}
