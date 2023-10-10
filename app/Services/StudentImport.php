<?php

namespace App\Services;

use App\Repositories\AcademicPlanRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\UploadedFile;

class StudentImport
{
    protected StudentRepository $studentRepository;
    protected AcademicPlanRepository $academicPlanRepository;

    public function importCsv(UploadedFile $file)
    {
        $students = $this->csvToArray($file);
    }

    public function storeStudentInfo()
    {

    }

    public function addStudentInputField()
    {

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
