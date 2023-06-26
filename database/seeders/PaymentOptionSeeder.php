<?php

namespace Database\Seeders;

use App\Models\PaymentOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentOption::insert(array(
            array('id' => '1','type' => 'cash','name' => 'Cash Payment','enabled' => '1','created_at' => '2023-06-26 19:35:39','updated_at' => '2023-06-26 19:35:39'),
            array('id' => '2','type' => 'bank','name' => 'DBBL Account 14810302792','enabled' => '1','created_at' => '2023-06-26 19:36:30','updated_at' => '2023-06-26 19:36:30'),
            array('id' => '3','type' => 'bank','name' => 'Bank Asia 0841236','enabled' => '1','created_at' => '2023-06-26 19:36:44','updated_at' => '2023-06-26 19:36:44'),
            array('id' => '4','type' => 'wallet','name' => 'BKash 01689553434','enabled' => '1','created_at' => '2023-06-26 19:37:42','updated_at' => '2023-06-26 19:37:42')
          ));
    }
}
