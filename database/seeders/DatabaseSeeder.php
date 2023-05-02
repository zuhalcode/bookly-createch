<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\Slot;
use App\Models\User;
use App\Models\AddOn;
use App\Models\Cover;
use App\Models\Company;
use App\Models\Holiday;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Database\Factories\JawaCityFactory;



// Maira
use Database\Factories\RiauCityFactory;
use Database\Factories\AcehCityFactory;
use Database\Factories\BaliCityFactory;
use Database\Factories\BantenCityFactory;
use Database\Factories\BengkuluCityFactory;
use Database\Factories\YogyakartaCityFactory;
use Database\Factories\JakartaCityFactory;
use Database\Factories\GorontaloCityFactory;
use Database\Factories\JambiCityFactory;
use Database\Factories\PapuaCityFactory;
use Database\Factories\PapuabaratCityFactory;
use Database\Factories\SumaterabaratCityFactory;
use Database\Factories\SumateraselatanCityFactory;
use Database\Factories\SumaterautaraCityFactory;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->count(3)->create();
        User::factory()->count(6)->create();
        Province::factory()->count(34)->create();
        JawaCityFactory::new()->count(67)->create();
        Company::factory()->count(3)->create();
        Holiday::factory()->count(30)->create();
        Cover::factory()->count(3)->create();
        Product::factory()->count(20)->create();
        Slot::factory()->count(20)->create();
        AddOn::factory()->count(20)->create();

        // Jasmine



        // Maira
        RiauCityFactory::new()->count(10)->create();
        AcehCityFactory::new()->count(23)->create();
        BaliCityFactory::new()->count(10)->create();
        BantenCityFactory::new()->count(4)->create();
        BengkuluCityFactory::new()->count(6)->create();
        YogyakartaCityFactory::new()->count(5)->create();
        JakartaCityFactory::new()->count(5)->create();
        GorontaloCityFactory::new()->count(3)->create();
        JambiCityFactory::new()->count(10)->create();
        PapuaCityFactory::new()->count(29)->create();
        PapuabaratCityFactory::new()->count(11)->create();
        SumaterabaratCityFactory::new()->count(14)->create();
        SumateraselatanCityFactory::new()->count(15)->create();
        SumaterautaraCityFactory::new()->count(29)->create();
    }
}
  