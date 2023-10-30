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
            'bill_generate_send_sms_format' => 'Dear Guardian, You are requested to pay the Transport bill :amount BDT for the month of :month_year within :due_date via link :payment_link. Thank you,  - BAFSKBUS'
        ];

        foreach ($settings as $name => $value) {
            Setting::create(compact('name', 'value'));
        }
    }
}
