<?php

use Illuminate\Database\Seeder;

// Model
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
        $users = [
            [
                'name' => 'mfaisal1091999',
                'email' => 'mfaisal1091999@gmail.com',
                'password' => Hash::make('mfaisal1091999'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
