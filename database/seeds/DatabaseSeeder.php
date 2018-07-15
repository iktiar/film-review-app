<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        $this->call(FilmGenresTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(GenresTableSeeder::class);
        $this->call(FilmsTableSeeder::class);
       
        Model::reguard();
    }
}
