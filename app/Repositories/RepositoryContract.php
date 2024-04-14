<?php

namespace App\Repositories;

interface RepositoryContract
{
    public function all(): ?array;

    public function find(int $id): ?array;

    public function findOrFail(int $id): ?array;

    public function updateOrCreate(array $require, array $data): ?array;

    public function create(array $data): ?array;

    public function update(int $id, array $data): ?array;

    public function delete(int $id): ?array;
}
