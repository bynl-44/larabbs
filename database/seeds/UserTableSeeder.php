<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 100)->create();
        $user = \App\Models\User::find(1);
        $user -> name = 'admin';
        $user -> email = 'zizizig@163.com';
        $user -> password = bcrypt('admin');
        $user -> save();
    }
}
