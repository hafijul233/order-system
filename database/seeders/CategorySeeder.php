<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::insert($this->data());
        Schema::enableForeignKeyConstraints();
    }

    private function data()
    {
        return array(
            array('id' => '1', 'name' => '{"en": "Home Products"}', 'slug' => 'home-products', 'parent_id' => NULL, 'lft' => '2', 'rgt' => '473', 'depth' => '1', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:37', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '2', 'name' => '{"en": "Access Control"}', 'slug' => 'access-control', 'parent_id' => '1', 'lft' => '41', 'rgt' => '42', 'depth' => '2', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '3', 'name' => '{"en": "Amplifiers"}', 'slug' => 'amplifiers', 'parent_id' => '1', 'lft' => '39', 'rgt' => '40', 'depth' => '2', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '4', 'name' => '{"en": "Antennas"}', 'slug' => 'antennas', 'parent_id' => '1', 'lft' => '43', 'rgt' => '44', 'depth' => '2', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '5', 'name' => '{"en": "Audio Components"}', 'slug' => 'audio-components', 'parent_id' => '1', 'lft' => '3', 'rgt' => '38', 'depth' => '2', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '6', 'name' => '{"en": "4K Players"}', 'slug' => '4k-players', 'parent_id' => '5', 'lft' => '8', 'rgt' => '9', 'depth' => '3', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '7', 'name' => '{"en": "Blu-ray Players"}', 'slug' => 'blu-ray-players', 'parent_id' => '5', 'lft' => '10', 'rgt' => '11', 'depth' => '3', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '8', 'name' => '{"en": "CD Changers"}', 'slug' => 'cd-changers', 'parent_id' => '5', 'lft' => '16', 'rgt' => '17', 'depth' => '3', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '9', 'name' => '{"en": "CD Single Disc Players"}', 'slug' => 'cd-single-disc-players', 'parent_id' => '5', 'lft' => '4', 'rgt' => '5', 'depth' => '3', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
            array('id' => '10', 'name' => '{"en": "Integrated Amplifiers"}', 'slug' => 'integrated-amplifiers', 'parent_id' => '5', 'lft' => '18', 'rgt' => '19', 'depth' => '3', 'enabled' => '1', 'created_at' => '2022-08-31 18:30:38', 'updated_at' => '2023-04-20 02:47:54', 'deleted_at' => NULL),
        );
    }
}
