<?php

namespace App\Repositories;

use App\Models\SmsLog;
use Illuminate\Http\Request;

class SmsLogRepository extends Repository
{
    public function model()
    {
        return SmsLog::class;
    }

    public function storeByRequest($phone, $message, $status = 'success')
    {
        return $this->query()->create([
            'phone' => $phone,
            'message' => $message,
            'status' => $status,
        ]);
    }


    public function deleteByRequest($smsLogId)
    {
        return $this->query()->findOrFail($smsLogId)?->delete();
    }

}
