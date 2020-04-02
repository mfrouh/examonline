<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\User::class,150)->create();
        factory(App\group::class,150)->create();
        factory(App\exam::class,200)->create();
        factory(App\question::class,450)->create();
    }
}
