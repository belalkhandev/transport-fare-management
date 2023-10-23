<?php

namespace App\Repositories;

use App\Models\TransportBilling;
use Illuminate\Http\Request;

class TransportBillingRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return TransportBilling::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }

    public function updateByRequest(Request $request, $transportBillingId)
    {
        return $this->query()->findOrFail($transportBillingId)->update([

            ]);
    }

    public function deleteByRequest($transportBillingId)
    {
        return $this->query()->findOrFail($transportBillingId)->delete();
    }

    public function generateMonthlyBill($request, $students)
    {
        foreach ($students as $student)
        {
            $transportBill = $this->storeTransportBillForStudent($student, $request->month, $request->year);

            //sendSMS
        }
    }

    private function storeTransportBillForStudent($student, $month, $year, $dueDate)
    {
        return $this->query()->createOrUpdate([
            'student_id' => $student->id,
            'academic_plan_id' => $student->academicPlans->first()->id,
            'month' => $month,
            'year' => $year,
            'due_date' => $dueDate,
            'amount' => $student->transportFee->discounted_amount ?? $student->transportFee->amount,
            'is_paid' => 0,
        ]);
    }

}
