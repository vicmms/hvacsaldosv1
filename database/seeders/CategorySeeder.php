<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            [
                'name' => 'Equipos HVAC',
                'slug' => Str::slug('Equipos HVAC'),
                'icon' => '<i class="fas fa-mobile-alt"></i>'
            ],
            [
                'name' => 'Refacciones Mecánicas',
                'slug' => Str::slug('Refacciones Mecánicas'),
                'icon' => '<i class="fas fa-tv"></i>'
            ],

            [
                'name' => 'Refacciones Eléctricas',
                'slug' => Str::slug('Refacciones Eléctricas'),
                'icon' => '<i class="fas fa-gamepad"></i>'
            ],

            [
                'name' => 'Refacciones Electrónicas',
                'slug' => Str::slug('Refacciones Electrónicas'),
                'icon' => '<i class="fas fa-laptop"></i>'
            ],

            [
                'name' => 'Controles',
                'slug' => Str::slug('Controles'),
                'icon' => '<i class="fas fa-tshirt"></i>'
            ],

            [
                'name' => 'Materiales Eléctricos',
                'slug' => Str::slug('Materiales Eléctricos'),
                'icon' => '<i class="fas fa-tshirt"></i>'
            ],

            [
                'name' => 'Materiales Mecánicos',
                'slug' => Str::slug('Materiales Mecánicos'),
                'icon' => '<i class="fas fa-tshirt"></i>'
            ],
            [
                'name' => 'Herramientas y Accesorios',
                'slug' => Str::slug('Herramientas y Accesorios'),
                'icon' => '<i class="fas fa-tshirt"></i>'
            ],

            [
                'name' => 'Accesorios de HVAC',
                'slug' => Str::slug('Accesorios de HVAC'),
                'icon' => '<i class="fas fa-tshirt"></i>'
            ],

            [
                'name' => 'Accesorios de Refrigeración',
                'slug' => Str::slug('Accesorios de Refrigeración'),
                'icon' => '<i class="fas fa-tshirt"></i>'
            ],

        ];

        foreach ($categories as $category) {
            $category = Category::factory(1)->create($category)->first();

            // $brands = Brand::factory(4)->create();

            // foreach ($brands as $brand) {
            //     $brand->categories()->attach($category->id);
            // }
            // Category::create(
            //     $category
            // );
        }
    }
}
