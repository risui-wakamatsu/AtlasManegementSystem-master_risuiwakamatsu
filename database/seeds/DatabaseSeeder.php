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
        //下記を呼び出す記述
        $this->call(UsersTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
    }
}
