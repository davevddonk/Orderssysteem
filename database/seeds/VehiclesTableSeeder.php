<?php

use Illuminate\Database\Seeder;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20; $i++) { 
            DB::table('vehicles')->insert([
                'id' => Null,
                'name' => 'wagen_0' . $i,
                'brand' => 'volkswagen',
                'licence' => '6-ERS-6' . $i,
                'volume' => '700',
                'created_by' => 'admin'
            ]);
        }
        
    }
}
