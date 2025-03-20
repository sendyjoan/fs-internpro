<?php

namespace App\Repositories\Eloquent;

use App\Models\School;
use App\Repositories\Contracts\SchoolRepositoryInterface;


class SchoolRepository implements SchoolRepositoryInterface
{
    protected $school;

    public function __construct(School $school)
    {
        $this->school = $school;
    }

    public function getAll()
    {
        return $this->school->all();
    }

    public function findById($id)
    {
        return $this->school->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->school->create($data);
    }

    public function update($id, array $data)
    {
        $school = $this->findById($id);
        $school->update($data);
        return $school;
    }

    public function delete($id)
    {
        $school = $this->findById($id);
        return $school->delete();
    }
}
