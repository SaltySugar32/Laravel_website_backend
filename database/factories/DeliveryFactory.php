<?php

namespace Database\Factories;

use App\Models\Checklist;
use App\Models\Delivery;
use App\Models\DeliveryAddress;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class DeliveryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Delivery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'delivery_address_id'=>function(){return DeliveryAddress::orderBy(DB::raw('RAND()'))->first()->id;},
            'user_profile_id'=>function(){return UserProfile::orderBy(DB::raw('RAND()'))->first()->id;},
            'delivery_date_time'=>$this->faker->dateTime,
            'delivery_status'=>$this->faker->numberBetween(0,3),
            'checklist_top_id'=>function(){return Checklist::orderBy(DB::raw('RAND()'))->first()->top_id;}
        ];
    }
}
