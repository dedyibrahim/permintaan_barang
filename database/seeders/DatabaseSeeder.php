<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\FileIterator\Factory;
use App\Models\User;
use App\Models\Barangs;
use App\Models\karyawans;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Barangs::factory(10)->create();

        karyawans::factory(10)->create();

        DB::table('users')->insert([
            'name' => "Administrator",
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
        ]);
    }
}
