<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2a$12$GkmowLtYMm2MtRP4ZR7kiOM00TsmSrz8y8LNs3NL7gIo9sQgPlhia',
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Institution',
                'email'          => 'institution@institution.com',
                'password'       => '$$2a$12$GkmowLtYMm2MtRP4ZR7kiOM00TsmSrz8y8LNs3NL7gIo9sQgPlhia',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
