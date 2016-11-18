<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	DB::table('users')->insert([
            'id' => Null,
            'email' => 'pietmeeresman@hotmail.com',
            'password' => Hash::make('pass'),
            'firstname' => 'piet',
            'lastname' => 'meeresman',
            'licence' => '',
            'city' => str_random(10),
            'adres' => str_random(10),
            'zipcode' => str_random(6),
            'rights' => 'planner',
            'created_by' => 'admin'
        ]);

        DB::table('users')->insert([
            'id' => Null,
            'email' => 'janvandongeren@hotmail.com',
            'password' => Hash::make('pass'),
            'firstname' => 'jan',
            'lastname' => 'van dongeren',
            'licence' => '',
            'city' => str_random(10),
            'adres' => str_random(10),
            'zipcode' => str_random(6),
            'rights' => 'chauffeur',
            'created_by' => 'admin'
        ]);

        DB::table('users')->insert([
            'id' => Null,
            'email' => 'franskeizer@hotmail.com',
            'password' => Hash::make('pass'),
            'firstname' => 'frans',
            'lastname' => 'keizer',
            'licence' => '',
            'city' => str_random(10),
            'adres' => str_random(10),
            'zipcode' => str_random(6),
            'rights' => 'chauffeur',
            'created_by' => 'admin'
        ]);

        DB::table('users')->insert([
            'id' => Null,
            'email' => 'erikvandenborg@hotmail.com',
            'password' => Hash::make('pass'),
            'firstname' => 'erik',
            'lastname' => 'van den borg',
            'licence' => '',
            'city' => str_random(10),
            'adres' => str_random(10),
            'zipcode' => str_random(6),
            'rights' => 'chauffeur',
            'created_by' => 'admin'
        ]);

        DB::table('users')->insert([
            'id' => Null,
            'email' => 'thijsvanmierlo@hotmail.com',
            'password' => Hash::make('pass'),
            'firstname' => 'thijs',
            'lastname' => 'van mierlo',
            'licence' => '',
            'city' => str_random(10),
            'adres' => str_random(10),
            'zipcode' => str_random(6),
            'rights' => 'administratie',
            'created_by' => 'admin'
        ]);
    }
}
