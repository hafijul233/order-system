<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('constant.status_model') as $model => $label) {
            Status::insert([
                array('model' => $model, 'icon' => 'fas fa-check', 'name' => 'Active', 'code' => 'active', 'color' => '#42BA96', 'description' => "{$label} Active Description", 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'is_default' => '1', 'enabled' => '1', 'created_at' => '2023-03-31 22:35:53', 'updated_at' => '2023-04-09 21:53:55', 'deleted_at' => NULL),
                array('model' => $model, 'icon' => 'fas fa-walking', 'name' => 'Temporary', 'code' => 'temporary', 'color' => '#6c757d', 'description' => "{$label} Temporary Description", 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'is_default' => '0', 'enabled' => '1', 'created_at' => '2023-03-31 22:38:52', 'updated_at' => '2023-04-01 08:13:41', 'deleted_at' => NULL),
                array('model' => $model, 'icon' => 'fas fa-pause', 'name' => 'Suspended', 'code' => 'suspended', 'color' => '#ffc107', 'description' => "{$label} Suspended Description", 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'is_default' => '0', 'enabled' => '1', 'created_at' => '2023-04-01 08:10:39', 'updated_at' => '2023-04-01 08:13:41', 'deleted_at' => NULL),
                array('model' => $model, 'icon' => 'fas fa-ban', 'name' => 'Banned', 'code' => 'banned', 'color' => '#dc3545', 'description' => "{$label} Banned Description", 'parent_id' => NULL, 'lft' => NULL, 'rgt' => NULL, 'depth' => NULL, 'is_default' => '0', 'enabled' => '1', 'created_at' => '2023-04-01 08:11:21', 'updated_at' => '2023-04-01 08:13:41', 'deleted_at' => NULL),
            ]);
        }
    }
}
