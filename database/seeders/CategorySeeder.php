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
            array('id' => '2', 'name' => '{"en": "Fruits"}', 'slug' => '{"en": "fruits"}', 'parent_id' => NULL, 'lft' => '2', 'rgt' => '5', 'depth' => '1', 'created_at' => '2023-03-26 13:32:22', 'updated_at' => '2023-03-26 13:37:35', 'deleted_at' => NULL),
            array('id' => '3', 'name' => '{"en": "Bread and baked goods"}', 'slug' => '{"en": "bread-and-baked-goods"}', 'parent_id' => '2', 'lft' => '3', 'rgt' => '4', 'depth' => '2', 'created_at' => '2023-03-26 13:35:18', 'updated_at' => '2023-03-26 13:40:07', 'deleted_at' => NULL),
            array('id' => '4', 'name' => '{"en": "Meat and fish"}', 'slug' => '{"en": "meat-and-fish"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:40:52', 'updated_at' => '2023-03-26 13:40:52', 'deleted_at' => NULL),
            array('id' => '5', 'name' => '{"en": "Pasta, rice, and cereals"}', 'slug' => '{"en": "pasta-rice-and-cereals"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:41:32', 'updated_at' => '2023-03-26 13:43:35', 'deleted_at' => NULL),
            array('id' => '6', 'name' => '{"en": "Sauces and condiments"}', 'slug' => '{"en": "sauces-and-condiments"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:44:16', 'updated_at' => '2023-03-26 13:46:14', 'deleted_at' => NULL),
            array('id' => '7', 'name' => '{"en": "Frozen foods"}', 'slug' => '{"en": "frozen-foods"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:44:54', 'updated_at' => '2023-03-26 13:46:41', 'deleted_at' => NULL),
            array('id' => '8', 'name' => '{"en": "Snacks"}', 'slug' => '{"en": "snacks"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:47:29', 'updated_at' => '2023-03-26 13:47:29', 'deleted_at' => NULL),
            array('id' => '9', 'name' => '{"en": "Personal care"}', 'slug' => '{"en": "personal-care"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:48:16', 'updated_at' => '2023-03-26 13:49:59', 'deleted_at' => NULL),
            array('id' => '10', 'name' => '{"en": "Pet care"}', 'slug' => '{"en": "pet-care"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:51:03', 'updated_at' => '2023-03-26 13:51:03', 'deleted_at' => NULL),
            array('id' => '11', 'name' => '{"en": "Vegetable"}', 'slug' => '{"en": "vegetable"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:51:51', 'updated_at' => '2023-03-26 13:55:04', 'deleted_at' => NULL),
            array('id' => '12', 'name' => '{"en": "Baby products"}', 'slug' => '{"en": "baby-products"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 13:59:23', 'updated_at' => '2023-03-26 13:59:23', 'deleted_at' => NULL),
            array('id' => '13', 'name' => '{"en": "Drinks"}', 'slug' => '{"en": "drinks"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:00:52', 'updated_at' => '2023-03-26 14:01:50', 'deleted_at' => NULL),
            array('id' => '14', 'name' => '{"en": "Herbs and spices"}', 'slug' => '{"en": "herbs-and-spices"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:03:06', 'updated_at' => '2023-03-26 14:03:06', 'deleted_at' => NULL),
            array('id' => '15', 'name' => '{"en": "Cans and jars"}', 'slug' => '{"en": "cans-and-jars"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:04:16', 'updated_at' => '2023-03-26 14:10:32', 'deleted_at' => NULL),
            array('id' => '16', 'name' => '{"en": "Meat alternatives"}', 'slug' => '{"en": "meat-alternatives"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:04:59', 'updated_at' => '2023-03-26 14:04:59', 'deleted_at' => NULL),
            array('id' => '18', 'name' => '{"en": "Dairy"}', 'slug' => '{"en": "dairy"}', 'parent_id' => NULL, 'lft' => '0', 'rgt' => '0', 'depth' => '0', 'created_at' => '2023-03-26 14:08:12', 'updated_at' => '2023-03-26 14:08:12', 'deleted_at' => NULL)
        );
    }
}
