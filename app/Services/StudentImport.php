<?php

namespace App\Services;

use App\Repositories\AcademicPlanRepository;
use App\Repositories\AreaRepository;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportFeeRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StudentImport
{
    protected StudentRepository $studentRepository;

    protected AreaRepository $areaRepository;
    protected FeeRepository $feeRepository;
    protected TransportFeeRepository $transportFeeRepository;

    public function importCsv(UploadedFile $file)
    {
        $students = $this->csvToArray($file);
        $newStudents = collect();

        if (count($students) > 0) {
            foreach ($students as $student) {
                DB::beginTransaction();
                $data = $this->storeStudentInfo($student);

                if ($data && $data->wasRecentlyCreated) {
                    $newStudents->add($data['student']);
                }

                DB::commit();
            }
        }

        return $newStudents;

    }

    public function storeStudentInfo($studentInfo)
    {
        if (!$studentInfo['student_id']) {
            return null;
        }

        $this->studentRepository = app(StudentRepository::class);
        $this->areaRepository = app(AreaRepository::class);
        $this->feeRepository = app(FeeRepository::class);
        $this->transportFeeRepository = app(TransportFeeRepository::class);


        $student = $this->studentRepository->query()
            ->ofStudentId($studentInfo['student_id'])
            ->first();

        if (!$student) {
            $student = $this->studentRepository->storeByImportData($studentInfo);

            if (isset($studentInfo['academic_plan_id']) && $studentInfo['academic_plan_id']) {
                $studentInfo->academicPlans()->attach([$studentInfo['academic_plan_id']]);
            }

            if (isset($studentInfo['area'], $studentInfo['fee']) && $studentInfo['area'] && $studentInfo['fee']) {
                $area = $this->areaRepository->query()->firstOrCreate([
                    'name' => $studentInfo['area']
                ]);

                $fee = $this->feeRepository->query()->firstOrCreate([
                    'area_id' => $area->id,
                    'amount' => $studentInfo['fee']
                ]);

                $this->transportFeeRepository->create([
                    'fee_id' => $fee->id,
                    'student_id' => $student->id,
                    'discounted_amount' => $studentInfo['discounted_amount'] ?? null
                ]);
            }
        }

        return $student;
    }

    private function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
