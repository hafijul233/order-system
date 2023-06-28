<?php

namespace Database\Seeders;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
        Setting::insert($this->data());
    }

    private function data(): array
    {
        return array(
            array('key' => 'notifications','name' => 'Notifications','description' => 'Display notification on the admin panel','value' => '0','field' => '{"name":"value","label":"Enabled?","type":"boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-03-18 14:28:46'),
            array('key' => 'refresh_interval','name' => 'Notification Refresh Interval','description' => 'Notification top Manu update interval(miliseonds) on admin panel','value' => '5000','field' => '{"name":"value","label":"Interval","type":"number"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-03-18 14:28:46'),
            array('key' => 'developer_mode','name' => 'Developer Mode','description' => 'Enable Developer Mode Enabled debugging Features','value' => '1','field' => '{"name": "value", "label": "Enabled", "type": "boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-06-27 13:35:33'),
            array('key' => 'query_logger','name' => 'Database Query Logger','description' => 'Enable or Disabled Database Query Logger. Enabling with slower the system. ','value' => '0','field' => '{"name": "value", "label": "Enabled", "type": "boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-03-18 14:45:22'),
            array('key' => 'contact_email','name' => 'Contact form email address','description' => 'The email address that all emails from the contact form will go to.','value' => 'admin@updivision.com','field' => '{"name":"value","label":"Value","type":"email"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'item_label','name' => 'Item Label','description' => 'the item or product field label','value' => 'Item','field' => '{"name":"value","label":"Label","type":"text"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'order_label','name' => 'Order Label','description' => 'the order field label','value' => 'Order','field' => '{"name":"value","label":"Label","type":"text"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'order_prefix','name' => 'Order Number Prefix','description' => 'Prefix text that will the added before every order number','value' => '#','field' => '{"name":"value","label":"Prefix Text","type":"text"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'order_number_length','name' => 'Order Number Length','description' => 'The max length of the order number (zero filled)','value' => '8','field' => '{"name":"value","label":"Length","type":"number"}','active' => '1','created_at' => NULL,'updated_at' => NULL),
            array('key' => 'customer_login','name' => 'Allow customer login on the system','description' => 'Display password and password confirmation field to set login credentials, for customers to log in on the system.','value' => '0','field' => '{"name":"value","label":"Allowed?","type":"boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-03-18 14:28:46'),
            array('key' => 'delivery_enabled','name' => 'Enable Delivery Options','description' => 'Display delivery options on order section if enabled','value' => '0','field' => '{"name":"value","label":"Enabled?","type":"boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-06-28 05:13:41'),
            array('key' => 'frontend_enabled','name' => 'Frontend Enabled','description' => 'Enable Product Display page for public and customers','value' => '0','field' => '{"name":"value","label":"Enabled?","type":"boolean"}','active' => '1','created_at' => '2023-03-18 20:09:45','updated_at' => '2023-06-29 02:20:48')
          );
    }
}
