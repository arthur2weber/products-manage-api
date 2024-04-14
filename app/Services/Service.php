<?php

namespace App\Services;

use App\Repositories\RepositoryContract;

class Service implements ServiceContract
{
    protected RepositoryContract $repository;

    public function all(): ?array
    {
        return $this->repository->all();
    }

    public function find(int $id): ?array
    {
        return $this->repository->findOrFail($id);
    }

    public function create(array $data): ?array
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): ?array
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): ?array
    {
        return $this->repository->delete($id);
    }
}
