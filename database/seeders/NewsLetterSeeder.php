<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Newsletter::insert($this->data());
    }

    private function data()
    {
        return array(
            array('id' => '1','newsletterable_type' => 'App\\Models\\Customer','newsletterable_id' => '1','email' => 'schamberger.shawn@example.net','attempted' => '49','subscribed' => '1','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '2','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '1','email' => 'gutkowski.maeve@example.com','attempted' => '83','subscribed' => '0','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '3','newsletterable_type' => 'App\\Models\\Customer','newsletterable_id' => '2','email' => 'homenick.eldred@example.net','attempted' => '3','subscribed' => '0','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '4','newsletterable_type' => 'App\\Models\\Customer','newsletterable_id' => '3','email' => 'nya78@example.org','attempted' => '85','subscribed' => '0','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '5','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '2','email' => 'okihn@example.org','attempted' => '85','subscribed' => '1','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '6','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '3','email' => 'lea.grady@example.org','attempted' => '97','subscribed' => '0','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '7','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '3','email' => 'bins.rhett@example.org','attempted' => '35','subscribed' => '1','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '8','newsletterable_type' => 'App\\Models\\Customer','newsletterable_id' => '4','email' => 'lula79@example.com','attempted' => '53','subscribed' => '0','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '9','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '4','email' => 'phahn@example.com','attempted' => '9','subscribed' => '1','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '10','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '5','email' => 'rippin.eldridge@example.net','attempted' => '93','subscribed' => '0','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '11','newsletterable_type' => 'App\\Models\\Customer','newsletterable_id' => '6','email' => 'davonte.mcclure@example.net','attempted' => '2','subscribed' => '1','created_at' => '2023-04-30 15:28:00','updated_at' => '2023-04-30 15:28:00','deleted_at' => NULL),
            array('id' => '12','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '7','email' => 'daniella.huels@example.com','attempted' => '90','subscribed' => '0','created_at' => '2023-04-30 15:28:01','updated_at' => '2023-04-30 15:28:01','deleted_at' => NULL),
            array('id' => '13','newsletterable_type' => 'App\\Models\\Customer','newsletterable_id' => '8','email' => 'barton.josephine@example.com','attempted' => '24','subscribed' => '1','created_at' => '2023-04-30 15:28:01','updated_at' => '2023-04-30 15:28:01','deleted_at' => NULL),
            array('id' => '14','newsletterable_type' => 'App\\Models\\Company','newsletterable_id' => '9','email' => 'bartell.jane@example.net','attempted' => '74','subscribed' => '1','created_at' => '2023-04-30 15:28:01','updated_at' => '2023-04-30 15:28:01','deleted_at' => NULL),
            array('id' => '15','newsletterable_type' => 'App\\Models\\Customer','newsletterable_id' => '10','email' => 'skiles.estel@example.com','attempted' => '46','subscribed' => '0','created_at' => '2023-04-30 15:28:01','updated_at' => '2023-04-30 15:28:01','deleted_at' => NULL)
        );
    }
}
