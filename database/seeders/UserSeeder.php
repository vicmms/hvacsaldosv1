<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create(['name' => 'admin']);

        User::create([
            'name' => 'Victor Morales',
            'email' => 'victor.morales@nanodela.com',
            'country_id' => 1,
            'password' => bcrypt('Victor@2021'),
        ])->assignRole('admin');


        User::factory(2)->create();
    }
}
