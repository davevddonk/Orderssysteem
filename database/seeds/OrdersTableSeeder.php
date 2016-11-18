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
            'pick_up_adres_id' => '1',
            'deliver_adres_id' => '2',
            'sender_id' => '1',
            'client_id' => '1',
            'deliver_time_til' => new DateTime(),
            'pick_up_time_from' => new DateTime(),
            'orderref' => '132',
            'created_at' => new DateTime('today'),
        ]);
    }
}
