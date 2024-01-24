<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'administrator',
                'email' => 'admin@mail.com',
                'password' => bcrypt('admin123'),
                'last_login' => now(),
                'role' => 'admin'
            ],
        ];

        foreach ($data as $row) {
            $data = User::create($row);
        }
    }
}
