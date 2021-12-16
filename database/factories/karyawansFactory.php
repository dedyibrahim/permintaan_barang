<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class karyawansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_nik'        =>$this->faker->randomNumber(3, true).".".$this->faker->randomNumber(3, true).".".$this->faker->randomNumber(5, true),
            'nama'          =>$this->faker->name(),
            'department'    =>"Keuangan",
        ];
    }
}
