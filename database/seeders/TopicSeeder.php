<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topics')->insert([
            [
            'name' => "topic1"
            ],
            [ 
            'name' => "topic2"
            ],
            [ 
            'name' => "topic3"
            ]
        ]);
    }
}
