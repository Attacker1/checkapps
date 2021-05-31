<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userData = [
            'user_id' => $this->faker->unique()->numberBetween(0, 123456),
            'user_fio' => $this->faker->lastName . ' ' . $this->faker->firstName,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_phone' => $this->faker->unique()->phoneNumber,
            'referer_user_id' => 100500,
            'token_id' => Str::random(10),
            'password' => $this->faker->password(),
        ];
        
        return $userData;
    }
}
