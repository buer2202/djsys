<?php

use Illuminate\Database\Seeder;

use App\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $admin = new Admin;
        $admin->name = 'admin';
        $admin->password = '44bd43975244a249f9b5830e3849eb7d';
        $admin->save();
    }
}
