<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'due_config' => json_encode([
                'due_date_after_generate_bill' => 7,
                'fine_after_due_date' => 100
            ]),
            'bill_generate_send_sms_format' => 'Dear Guardian, You are request to pay transport bill :amount BDT for  :month_year, The payment deadline is  :due_date. Use payment link :payment_link or you may use the Merchant number: 01912123456, Thank you.  - BAFSKBUS',
            'payment_confirmation_sms' => ":month_year Transport Bill, Student ID: :student_id, Amount :amount BDT has been paid. Thank you. - BAFSK BUS",
            'due_alert_sms_format' => "Dear guardian, Please pay your due :amount for :month_year within :due_date using :payment_link or our merchant number: 01912123456. Thank you. BAFSK-BUS",
        ];

        foreach ($settings as $name => $value) {
            Setting::create(compact('name', 'value'));
        }
    }
}
