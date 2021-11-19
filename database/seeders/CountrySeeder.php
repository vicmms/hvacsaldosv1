<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'name' => 'México',
            'currency' => 'MXN',
            'delimiter' => ',',
            'denotation' => '$',
            'tld' => 'MX'
        ]);

        Country::create([
            'name' => 'Ecuador',
            'currency' => 'USD',
            'delimiter' => ',',
            'denotation' => '$',
            'tld' => 'EC'
        ]);

        Country::create([
            'name' => 'Costa Rica',
            'currency' => 'CRC',
            'delimiter' => ',',
            'denotation' => '₡',
            'tld' => 'CR'
        ]);

        Country::create([
            'name' => 'Chile',
            'currency' => 'CLP',
            'delimiter' => ',',
            'denotation' => '$',
            'tld' => 'CL'
        ]);
    }
}
