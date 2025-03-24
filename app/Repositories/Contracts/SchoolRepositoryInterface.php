<?php

namespace App\Repositories\Contracts;

interface SchoolRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getAllSchoolWithMembership();
}