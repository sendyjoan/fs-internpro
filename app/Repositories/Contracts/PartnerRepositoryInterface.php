<?php

namespace App\Repositories\Contracts;

interface PartnerRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function findByCode($code);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}