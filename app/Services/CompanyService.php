<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Segment;
use App\Models\Task;

class CompanyService
{
    public function createCompany($name)
    {
        $company = Company::create([
            'name' => $name,
        ]);

        return $company;
    }

    public function updateCompany($company, $name)
    {
        $company->update([
            'name' => $name,
        ]);

        return $company;
    }

    public function deleteCompany($company)
    {
        $company->delete();
    }

    public function addSegement($description, $companyId)
    {
        $segment = Segment::create([
            'description' => $description,
            'company_id' => $companyId,
        ]);

        return $segment;
    }

    public function addTask($segmentId, $taskName)
    {
        $getCurrentTaskCount = Task::whereSegmentId($segmentId)->count();
        $newPosition = $getCurrentTaskCount + 1;
        $task = Task::create([
            'name' => $taskName,
            'segment_id' => $segmentId,
            'position' => $newPosition,
        ]);

        return $task;
    }
}
