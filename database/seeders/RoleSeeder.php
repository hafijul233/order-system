<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $role) {
            Role::create($role);
        }

    }

    private function data()
    {
        return [
            ['name' => 'System Administrator'],
            ['name' => 'Administrator'],
            ['name' => 'Manager'],
            ['name' => 'Operator'],
        ];
    }
}
