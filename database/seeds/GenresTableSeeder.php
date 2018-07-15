<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class GenresTableSeeder
 */
class GenresTableSeeder extends Seeder {

    /**
     *
     */
    public function run() {

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('genres')->truncate();

        $types = [
            [
                'id' => 1,
                'name' => 'action',
                'display_name' => 'Action',
            ],
            [
                'id' => 2,
                'name' => 'adventure',
                'display_name' => 'Adventure',
            ],
            [
                'id' => 3,
                'name' => 'comedy',
                'display_name' => 'Comedy',
            ],
            [
                'id' => 4,
                'name' => 'crime',
                'display_name' => 'Crime',
            ],
            [
                'id' => 5,
                'name' => 'drama',
                'display_name' => 'Drama',
            ],
            [
                'id' => 6,
                'name' => 'historical',
                'display_name' => 'Historical',
            ],
            [

                'id' => 7,
                'name' => 'horror',
                'display_name' => 'Horror',
            ],
            [

                'id' => 8,
                'name' => 'political',
                'display_name' => 'Political',
            ]
        ];

        DB::table('genres')->insert($types);

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}