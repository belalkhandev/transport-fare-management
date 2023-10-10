<?php

namespace App\Repositories;

use App\Models\Student;
use App\Models\TransportFee;
use Illuminate\Http\Request;

class TransportFeeRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return TransportFee::class;
    }

    public function storeByRequestAndStudentId(Request $request, $studentId)
    {
        return $this->query()->create([
            'student_id' => $studentId,
            'fee_id' => $request->get('fee_id'),
            'discounted_amount' => $request->get('discounted_amount'),
            'remarks' => $request->get('remarks')
        ]);
    }

    public function updateByRequest(Request $request, $transportFeeId)
    {
        return $this->query()->findOrFail($transportFeeId)?->update([
            'fee_id' => $request->get('fee_id'),
            'discounted_amount' => $request->get('discounted_amount'),
            'remarks' => $request->get('remarks')
        ]);
    }
}
