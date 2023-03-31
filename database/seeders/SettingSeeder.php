<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('settings')->truncate();
        DB::table('settings')->insert($this->data());
    }

    private function data(): array
    {
        return array(
            array('key' => 'notifications','name' => 'Notifications','description' => 'Display notification on the admin panel','value' => '0','field' => '{"name":"value","label":"Enabled?","type":"boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-03-18 14:28:46'),
            array('key' => 'refresh_interval','name' => 'Notification Refresh Interval','description' => 'Notification top Manu update interval(miliseonds) on admin panel','value' => '5000','field' => '{"name":"value","label":"Interval","type":"number"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-03-18 14:28:46'),
            array('key' => 'developer_mode','name' => 'Developer Mode','description' => 'Enable Developer Mode Enabled debugging Features','value' => '0','field' => '{"name": "value", "label": "Enabled", "type": "boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-03-18 14:45:22'),
            array('key' => 'contact_email','name' => 'Contact form email address','description' => 'The email address that all emails from the contact form will go to.','value' => 'admin@updivision.com','field' => '{"name":"value","label":"Value","type":"email"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'contact_cc','name' => 'Contact form CC field','description' => 'Email addresses separated by comma, to be included as CC in the email sent by the contact form.','value' => '','field' => '{"name":"value","label":"Value","type":"text"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'contact_bcc','name' => 'Contact form BCC field','description' => 'Email addresses separated by comma, to be included as BCC in the email sent by the contact form.','value' => '','field' => '{"name":"value","label":"Value","type":"email"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'motto','name' => 'Motto','description' => 'Website motto','value' => 'this is the value','field' => '{"name":"value","label":"Value","type":"textarea"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
        );
    }
}
