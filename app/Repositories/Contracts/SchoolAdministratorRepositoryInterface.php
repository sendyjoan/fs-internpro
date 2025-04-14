<?php

namespace App\Repositories\Contracts;

interface SchoolAdministratorRepositoryInterface
{
    public function getAll($key);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}