<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $block) {
            Customer::create($block);
        }
    }

    private function data()
    {
        return array(
            array('id' => '1', 'name' => 'Russ Vukonich', 'email' => 'russ@eyehear.us', 'phone' => '+1-406-75-13181', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '2', 'name' => 'Cody Redmond', 'email' => 'cody@customcode.org', 'phone' => '+1-801-953-4000', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '3', 'name' => 'Scott Morris', 'email' => 'info@lanzaav.com', 'phone' => '+1-602-31-16163', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '4', 'name' => 'Devin Squire', 'email' => 'drssunvly@aol.com', 'phone' => '+1-602-95-35612', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '5', 'name' => 'Doug Evans', 'email' => 'doug@componentsaz.com', 'phone' => '+1-480-36-36526', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '6', 'name' => 'Jeremy Hancey', 'email' => 'jeremy@lynnsaudiovideo.com', 'phone' => '+1-435-75-23408', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '7', 'name' => 'Roberto', 'email' => 'accessautotint1@gmail.com', 'phone' => '+1-303-288-5117', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '8', 'name' => 'Cody', 'email' => 'codymurray1@yahoo.com', 'phone' => '+1-435-586-3388', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '9', 'name' => 'Tony', 'email' => 'duce_car_audio@hotmail.com', 'phone' => '+1-602-703-8983', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '10', 'name' => 'Jason Mcbride', 'email' => 'jason.iss@hotmail.com', 'phone' => '+1-435-76-03518', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
            array('id' => '11', 'name' => 'Travis Shupe', 'email' => 'travis@shupeelectric.com', 'phone' => '+1-801-29-26420', 'platform' => 'office', 'email_verified_at' => '2023-04-27 19:10:09', 'phone_verified_at' => '2023-04-27 19:10:09', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'remember_token' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:10:09', 'updated_at' => '2023-04-27 19:10:09', 'deleted_at' => NULL),
        );
    }
}
