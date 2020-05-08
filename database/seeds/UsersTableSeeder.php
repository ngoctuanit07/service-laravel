<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User();
        $user->name = 'Phil';
        $user->email = 'example@example.com';
        $user->password = bcrypt('123456');
       // $user->avatar_url = Storage::cloud()->url('profiles/no-avatar.png');
       // $user->username = 'freezabb';
      //  $user->bio = 'A musician, guitarist and app developer.';
        $user->save();

        $user->assignRole('admin', 'moderator', 'user');
    }
}
