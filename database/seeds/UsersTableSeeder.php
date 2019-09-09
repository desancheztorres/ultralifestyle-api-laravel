<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class, 3)->create();
        $userList = ["cristian@cristian.com", "oscar@oscar.com", "desancheztorres@gmail.com", "des@des.com"];

        foreach ($userList as $user) {
            $email = explode("@", $user);
            DB::table('users')->insert([
                'name' => $email[0],
                'email' =>$user,
                'email_verified_at' => now(),
                'password' => bcrypt('123456'), // password
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
