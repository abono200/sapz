<?php

namespace App\Services;

use App\Models\Programme;
use App\Models\ProgrammeMilestone;

class ProgrammeService
{
    public function getAllProgrammes()
    {
        return Programme::with(['coordinator', 'milestones'])->paginate(15);
    }

    public function createProgramme(array $data): Programme
    {
        return Programme::create($data);
    }

    public function getProgrammeDetails(string $id): ?Programme
    {
        return Programme::with(['coordinator', 'milestones'])->find($id);
    }

    public function addMilestone(Programme $programme, array $data): ProgrammeMilestone
    {
        return $programme->milestones()->create($data);
    }
}
