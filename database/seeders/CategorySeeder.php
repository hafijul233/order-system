<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert($this->data());
    }

    private function data()
    {
        return array(
            array('name' => '{"en": "Fruits"}', 'slug' => 'fruits', 'parent_id' => NULL, 'lft' => '2', 'rgt' => '5', 'depth' => '1', 'created_at' => '2023-03-26 13:32:22', 'updated_at' => '2023-03-26 13:37:35', 'deleted_at' => NULL),
            array('name' => '{"en": "Bread and baked goods"}', 'slug' => 'bread-and-baked-goods', 'parent_id' => '2', 'lft' => '3', 'rgt' => '4', 'depth' => '2', 'created_at' => '2023-03-26 13:35:18', 'updated_at' => '2023-03-26 13:40:07', 'deleted_at' => NULL),
            array('name' => '{"en": "Meat and fish"}', 'slug' => 'meat-and-fish', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:40:52', 'updated_at' => '2023-03-26 13:40:52', 'deleted_at' => NULL),
            array('name' => '{"en": "Pasta, rice, and cereals"}', 'slug' => 'pasta-rice-and-cereals', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:41:32', 'updated_at' => '2023-03-26 13:43:35', 'deleted_at' => NULL),
            array('name' => '{"en": "Sauces and condiments"}', 'slug' => 'sauces-and-condiments', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:44:16', 'updated_at' => '2023-03-26 13:46:14', 'deleted_at' => NULL),
            array('name' => '{"en": "Frozen foods"}', 'slug' => 'frozen-foods', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:44:54', 'updated_at' => '2023-03-26 13:46:41', 'deleted_at' => NULL),
            array('name' => '{"en": "Snacks"}', 'slug' => 'snacks', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:47:29', 'updated_at' => '2023-03-26 13:47:29', 'deleted_at' => NULL),
            array('name' => '{"en": "Personal care"}', 'slug' => 'personal-care', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:48:16', 'updated_at' => '2023-03-26 13:49:59', 'deleted_at' => NULL),
            array('name' => '{"en": "Pet care"}', 'slug' => 'pet-care', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:51:03', 'updated_at' => '2023-03-26 13:51:03', 'deleted_at' => NULL),
            array('name' => '{"en": "Vegetable"}', 'slug' => 'vegetable', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:51:51', 'updated_at' => '2023-03-26 13:55:04', 'deleted_at' => NULL),
            array('name' => '{"en": "Baby products"}', 'slug' => 'baby-products', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:59:23', 'updated_at' => '2023-03-26 13:59:23', 'deleted_at' => NULL),
            array('name' => '{"en": "Drinks"}', 'slug' => 'drinks', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:00:52', 'updated_at' => '2023-03-26 14:01:50', 'deleted_at' => NULL),
            array('name' => '{"en": "Herbs and spices"}', 'slug' => 'herbs-and-spices', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:03:06', 'updated_at' => '2023-03-26 14:03:06', 'deleted_at' => NULL),
            array('name' => '{"en": "Cans and jars"}', 'slug' => 'cans-and-jars', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:04:16', 'updated_at' => '2023-03-26 14:10:32', 'deleted_at' => NULL),
            array('name' => '{"en": "Meat alternatives"}', 'slug' => 'meat-alternatives', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:04:59', 'updated_at' => '2023-03-26 14:04:59', 'deleted_at' => NULL),
            array('name' => '{"en": "Dairy"}', 'slug' => 'dairy', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:08:12', 'updated_at' => '2023-03-26 14:08:12', 'deleted_at' => NULL)
        );
    }
}
