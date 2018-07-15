<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class FilmsTableSeeder
 */
class FilmsTableSeeder extends Seeder {

    /**
     *
     */
    public function run() {

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('films')->truncate();

        $types = [
            [
                'id' => 1,
                'name' => 'Hotel Transylvania 3',
                'slug' => 'hotel-transylvania-3',
                'description' => 'While on a vacation with his family, Count Dracula makes a romantic connection.',
                'release_date' => '2018-07-13',
                'rating' => 3,
                'ticket_price' => 8.5,
                'country' => 'USA',
                'photo' => 'hotel-transylvania-3.jpg',
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Skyscraper',
                'slug' => 'skyscraper',
                'description' => 'A father goes to great lengths to save his family from a burning skyscraper.',
                'release_date' => '2018-08-01',
                'rating' => 3.5,
                'ticket_price' => 6.5,
                'country' => 'USA',
                'photo' => 'skyscraper.jpg',
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Eighth Grade',
                'slug' => 'eighth_grade',
                'description' => 'A teenager tries to survive the last week of her disastrous eighth-grade year before leaving to start high school.',
                'release_date' => '2019-10-14',
                'rating' => 5,
                'ticket_price' => 7,
                'country' => 'UK',
                'photo' => 'eighth_grade.jpg',
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('films')->insert($types);

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}