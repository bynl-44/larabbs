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
        $user -> introduction = 'admin introduction.';
        $user -> save();
        $user = User::find(2);
        $user->name = 'zhangsan';
        $user->email = 'zhangsan@123.com';
        $user->password = bcrypt('admin');
        $user->introduction = '我是 zhangsan，是个 phper';
        $user->save();

    }
}
