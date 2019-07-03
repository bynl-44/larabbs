<?php

use App\Models\User;
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
        factory(User::class, 100)->create();
        $user = User::find(1);
        $user -> name = 'admin';
        $user -> email = 'admin@123.com';
        $user -> password = bcrypt('admin');
        $user -> save();
    }
}
