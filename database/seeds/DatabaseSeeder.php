<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdministrationUnitsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(VisitsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(RatingsTableSeeder::class);
        $this->call(GaragesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(BookmarksTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
    }
}
