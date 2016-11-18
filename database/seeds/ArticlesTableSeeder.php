<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'id' => '23273',
            'kg' => '',
            'm3' => '',
            'name' => 'Jasminum parkeri',
            'created_at' => new DateTime('today'),
        ]);

        DB::table('articles')->insert([
            'id' => '24140',
            'kg' => '',
            'm3' => '',
            'name' => 'Kadsura japonica',
            'created_at' => new DateTime('today'),
        ]);
    }
}
