<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\OptionBusinessDistribution::create(['name'=>'Diáfana']);
        App\OptionBusinessDistribution::create(['name'=>'1 a 2 estancias']);
        App\OptionBusinessDistribution::create(['name'=>'2 a 5 estancias']);
        App\OptionBusinessDistribution::create(['name'=>'5 a 10 estancias']);
        App\OptionBusinessDistribution::create(['name'=>'Más de 10 estancias']);

        \App\OptionBusinessFacade::create(['name'=>'Sin fachada']);
        \App\OptionBusinessFacade::create(['name'=>'1 a 4 metros']);
        \App\OptionBusinessFacade::create(['name'=>'5 a 8 metros']);
        \App\OptionBusinessFacade::create(['name'=>'9 a 12 metros']);
        \App\OptionBusinessFacade::create(['name'=>'Más de 12 metros']);

        \App\OptionBusinessLocation::create(['name'=>'En centro comercial']);
        \App\OptionBusinessLocation::create(['name'=>'A pie de calle']);
        \App\OptionBusinessLocation::create(['name'=>'Entreplanta']);
        \App\OptionBusinessLocation::create(['name'=>'Subterráneo']);
        \App\OptionBusinessLocation::create(['name'=>'Otros']);

        \App\OptionCurrentTenantsGender::create(['name'=>'Chico(s) y chica(s)']);
        \App\OptionCurrentTenantsGender::create(['name'=>'Sólo chico(s)']);
        \App\OptionCurrentTenantsGender::create(['name'=>'Sólo chica(s)']);

        \App\OptionGarageCapacity::create(['name'=>'Coche pequeño']);
        \App\OptionGarageCapacity::create(['name'=>'Coche grande']);
        \App\OptionGarageCapacity::create(['name'=>'Moto']);
        \App\OptionGarageCapacity::create(['name'=>'Coche y moto']);
        \App\OptionGarageCapacity::create(['name'=>'Dos coches o más']);

        \App\OptionNearestTownDistance::create(['name'=>'No lo sé']);
        \App\OptionNearestTownDistance::create(['name'=>'En núcleo urbano']);
        \App\OptionNearestTownDistance::create(['name'=>'Menos de 500 m']);
        \App\OptionNearestTownDistance::create(['name'=>'Entre 500 m y 1 km']);
        \App\OptionNearestTownDistance::create(['name'=>'De 1 a 2 km']);
        \App\OptionNearestTownDistance::create(['name'=>'De 2 a 5 km']);
        \App\OptionNearestTownDistance::create(['name'=>'De 5 a 10 km']);
        \App\OptionNearestTownDistance::create(['name'=>'Más de 10 km']);

        App\OptionOfficeDistribution::create(['name'=>'Diáfana']);
        App\OptionOfficeDistribution::create(['name'=>'Dividida con mamparas']);
        App\OptionOfficeDistribution::create(['name'=>'Dividida con tabiques']);

        \App\OptionPaymentDay::create(['name'=>'A la entrega de las llaves']);
        \App\OptionPaymentDay::create(['name'=>'Días antes']);
        \App\OptionPaymentDay::create(['name'=>'El día de entrada']);
        \App\OptionPaymentDay::create(['name'=>'El día de saluda']);

        \App\OptionSurroundings::create(['name'=>'Entorno de playa']);
        \App\OptionSurroundings::create(['name'=>'Entorno de esquí']);
        \App\OptionSurroundings::create(['name'=>'Entorno rural']);
        \App\OptionSurroundings::create(['name'=>'Entorno de ciudad']);

        \App\OptionTenantGender::create(['name'=>'Da igual']);
        \App\OptionTenantGender::create(['name'=>'Chico']);
        \App\OptionTenantGender::create(['name'=>'Chica']);

        \App\OptionTenantMinStay::create(['name'=>'1 mes']);
        \App\OptionTenantMinStay::create(['name'=>'2 meses']);
        \App\OptionTenantMinStay::create(['name'=>'3 meses']);
        \App\OptionTenantMinStay::create(['name'=>'4 meses']);
        \App\OptionTenantMinStay::create(['name'=>'5 meses']);
        \App\OptionTenantMinStay::create(['name'=>'6 o más meses']);

        \App\OptionTenantOccupation::create(['name'=>'Da igual']);
        \App\OptionTenantOccupation::create(['name'=>'Estudiante']);
        \App\OptionTenantOccupation::create(['name'=>'Con trabajo']);

        \App\OptionTenantSexualOrientation::create(['name'=>'Da igual']);
        \App\OptionTenantSexualOrientation::create(['name'=>'Gay friendly']);

        \App\EnergyCertification::create(['name'=>'Aún no disponible']);
        \App\EnergyCertification::create(['name'=>'A']);
        \App\EnergyCertification::create(['name'=>'B']);
        \App\EnergyCertification::create(['name'=>'C']);
        \App\EnergyCertification::create(['name'=>'D']);
        \App\EnergyCertification::create(['name'=>'E']);
        \App\EnergyCertification::create(['name'=>'F']);
        \App\EnergyCertification::create(['name'=>'G']);
        \App\EnergyCertification::create(['name'=>'Inmueble exento']);
        \App\EnergyCertification::create(['name'=>'En trámite']);
    }
}
