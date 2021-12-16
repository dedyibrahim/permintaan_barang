<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarangsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_barang'     =>$this->faker->numerify('ATK-#####'),
            'nama_barang'   =>"AMPLOP ".$this->faker->randomElement(["A","B","C","D","E","F","G","H","I","J"])." COKLAT JAYA",
            'qty'           =>$this->faker->randomNumber(5, false),
            'lokasi'        =>"L1-R1A",
            'satuan'        =>"Pak"
        ];
    }
}
