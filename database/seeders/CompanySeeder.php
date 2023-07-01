<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $block) {
            Company::create($block);
        }
    }

    private function data()
    {
        return array(
            array('id' => '1', 'name' => 'Vantage Voltage LLC', 'representative_id' => '1', 'designation' => 'CEO', 'email' => NULL, 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '2', 'name' => 'Creative Energy', 'representative_id' => '1', 'designation' => 'CEO', 'email' => NULL, 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '3', 'name' => 'Vision Smart Homes LLC', 'representative_id' => '1', 'designation' => 'CEO', 'email' => 'nater@mwd1.com', 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '4', 'name' => 'Sound And Cinema', 'representative_id' => '1', 'designation' => 'CEO', 'email' => NULL, 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '5', 'name' => 'Sound And Video Contractor LLC', 'representative_id' => '1', 'designation' => 'CEO', 'email' => NULL, 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '6', 'name' => 'Xtreme Theatre & Sound', 'representative_id' => '1', 'designation' => 'CEO', 'email' => 'aarons@mwd1.com', 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '7', 'name' => 'Revampit Audio Video LLC', 'representative_id' => '1', 'designation' => 'CEO', 'email' => NULL, 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '8', 'name' => 'Sounds Dynamic LLC', 'representative_id' => '1', 'designation' => 'CEO', 'email' => 'jerameyr@mwd1.com', 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '9', 'name' => 'Behlen Multimedia Ltd', 'representative_id' => '1', 'designation' => 'CEO', 'email' => 'aarons@mwd1.com', 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '10', 'name' => 'Coops Audio', 'representative_id' => '1', 'designation' => 'CEO', 'email' => NULL, 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            array('id' => '11', 'name' => 'Phoenix Alarm LLC', 'representative_id' => '1', 'designation' => 'CEO', 'email' => NULL, 'phone' => NULL, 'email_verified_at' => '2023-04-27 19:41:20', 'phone_verified_at' => '2023-04-27 19:41:20', 'newsletter_subscribed' => '1', 'block_reason' => NULL, 'note' => NULL, 'status_id' => '2', 'created_at' => '2023-04-27 19:41:20', 'updated_at' => '2023-04-27 19:41:20', 'deleted_at' => NULL),
            );
    }
}
