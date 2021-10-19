<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            /* Celulares y tablets */
            [
                'name' => 'Nuevo',
                'slug' => Str::slug('Nuevo'),
                // 'color' => true
            ],

            [
                'name' => 'Usado',
                'slug' => Str::slug('Usado'),
            ],

            [
                'name' => 'Sin Usar',
                'slug' => Str::slug('Sin Usar'),
            ],
        ];

        foreach ($subcategories as $subcategory) {


            Subcategory::create($subcategory);
        }
    }
}
