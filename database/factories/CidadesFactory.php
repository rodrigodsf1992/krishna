<?php

namespace Database\Factories;

use App\Models\Cidades;
use Illuminate\Database\Eloquent\Factories\Factory;

class CidadesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cidades::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->city,
            'estado' => $this->faker->state,
        ];
    }
}