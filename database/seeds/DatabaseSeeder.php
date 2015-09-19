<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
//        $this->call(OptionsTableSeeder::class);
//        $this->call(CategoriesTableSeeder::class);

        //if(\App::environment() == 'local')
//            $this->call(AdsTableSeeder::class);

        Model::reguard();
    }
}
