<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'      => 'Administrador',
            'email'     => 'admin@materialista',
            'password'  => bcrypt('!m4t3r14l1st4.'),
        ]);
    }
}