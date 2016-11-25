<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'id' => Null,
            'status' => 'recieved',
            'file' => '/files/1.xml',
            'deliver_time_til' => new DateTime(),
            'pick_up_time_from' => new DateTime(),
            'created_at' => new DateTime('today'),
        ]);
    }
}
