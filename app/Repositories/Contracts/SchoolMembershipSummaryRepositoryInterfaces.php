<?php

namespace App\Repositories\Contracts;

interface SchoolMembershipSummaryRepositoryInterfaces
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getSchoolMembershipSummaryBySchoolId($schoolId);
}