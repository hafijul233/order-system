<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert($this->data());
        
    }

    private function data()
    {
        return array(
            array('id' => '1','name' => 'Gram','conversion' => '1000.000','parent_id' => '3','lft' => '0','rgt' => '0','depth' => '0','enabled' => '1','description' => NULL,'created_at' => '2023-07-01 10:46:01','updated_at' => '2023-07-01 10:47:02','deleted_at' => NULL),
            array('id' => '2','name' => 'Kilogram','conversion' => '1000.000','parent_id' => '1','lft' => '0','rgt' => '0','depth' => '0','enabled' => '1','description' => NULL,'created_at' => '2023-07-01 10:46:25','updated_at' => '2023-07-01 10:46:25','deleted_at' => NULL),
            array('id' => '3','name' => 'Miligram','conversion' => '1.000','parent_id' => NULL,'lft' => '0','rgt' => '0','depth' => '0','enabled' => '1','description' => NULL,'created_at' => '2023-07-01 10:46:45','updated_at' => '2023-07-01 10:46:45','deleted_at' => NULL)
          );
    }
}
