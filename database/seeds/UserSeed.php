<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('123456'), 'role_id' => 3, 'remember_token' => '',],
            ['id' => 2, 'name' => 'Business User', 'email' => 'business@test.com', 'password' => bcrypt('123456'), 'role_id' => 2, 'remember_token' => '',],
            ['id' => 3, 'name' => 'Admin', 'email' => 'user@test.com', 'password' => bcrypt('123456'), 'role_id' => 1, 'remember_token' => '',],
        ];

        foreach ($items as $item) {
            \App\Models\User::create($item);
        }
    }
}
