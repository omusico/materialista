<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\CategoryBusiness::create(['name'=>'Local comercial']);
        \App\CategoryBusiness::create(['name'=>'Nave industrial']);

        \App\CategoryCountryHouse::create(['name'=>'Finca rústica']);
        \App\CategoryCountryHouse::create(['name'=>'Castillo']);
        \App\CategoryCountryHouse::create(['name'=>'Palacio']);
        \App\CategoryCountryHouse::create(['name'=>'Masía']);
        \App\CategoryCountryHouse::create(['name'=>'Cortijo']);
        \App\CategoryCountryHouse::create(['name'=>'Casa rural']);
        \App\CategoryCountryHouse::create(['name'=>'Casa de pueblo']);
        \App\CategoryCountryHouse::create(['name'=>'Casa terrera']);
        \App\CategoryCountryHouse::create(['name'=>'Torre']);
        \App\CategoryCountryHouse::create(['name'=>'Caserón']);

        \App\CategoryHouse::create(['name'=>'Casa/chalet independiente']);
        \App\CategoryHouse::create(['name'=>'Chalet pareado']);
        \App\CategoryHouse::create(['name'=>'Chalet adosado']);

        \App\CategoryLand::create(['name'=>'Urbano']);
        \App\CategoryLand::create(['name'=>'Urbanizable']);
        \App\CategoryLand::create(['name'=>'No urbanizable']);

        \App\CategoryLodging::create(['name'=>'Apartamento']); //apartamento, ático, estudio...
        \App\CategoryLodging::create(['name'=>'Casa']); //casa rural, chalet adosado...
        \App\CategoryLodging::create(['name'=>'Villa']); //Chalet independiente con jardín por los cuatro costados

        \App\CategoryRoom::create(['name'=>'Piso compartido']);
        \App\CategoryRoom::create(['name'=>'Casa/chalet compartido']);
    }
}