<?php

namespace Database\Factories;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $num=rand(8,15);
        return [
            'username'=> $this->faker->unique()->userName,
            //'password'=> $this->faker->password,
            'password'=> stripslashes($this->faker->regexify('[A-Za-z0-9]{10}')),
            'role'=>0,
        ];
    }
}
