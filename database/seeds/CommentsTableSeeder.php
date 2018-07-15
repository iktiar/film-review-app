<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentsTableSeeder
 */
class CommentsTableSeeder extends Seeder {

    /**
     *
     */
    public function run() {

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('comments')->truncate();

        $types = [
            [
                'id' => 1,
                'name' => 'Md Iktiar Rahman',
                'comment' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel euismod lacus, eget sagittis dolor. Donec lacinia sollicitudin est, a cursus sem semper a. Curabitur volutpat vel libero quis aliquam. Cras sed metus sed enim congue mollis. Sed sodales sodales ex, ut molestie turpis egestas sed. Curabitur nec porta dolor, quis mollis ante',
                'film_id' => 1,
                'user_id' => 3,
            ],
            [
                'id' => 2,
                'name' => 'demo user 2',
                'comment' => 'Demo comment2 .Lorem ipsum dolor sit amet, consectetur adipiscing elit. ',
                'film_id' => 2,
                'user_id' => 3,
            ],
            [
                'id' => 3,
                'name' => 'demo user 3',
                'comment' => 'Demo comment3 .Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'film_id' => 3,
                'user_id' => 3,
            ],
        ];

        DB::table('comments')->insert($types);

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}