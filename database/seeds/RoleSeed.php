<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'Personal'],
            ['id' => 2, 'title' => 'Business'],
            ['id' => 3, 'title' => 'Admin'],
        ];

        foreach ($items as $item) {
            \App\Models\Role::create($item);
        }
    }
}
