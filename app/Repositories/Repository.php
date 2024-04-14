<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryContract
{
    protected Model $model;

    public function all(): ?array
    {
        $registers = $this->model->all();

        return $registers->toArray();
    }

    public function find(int $id): ?array
    {
        $register = $this->model->find($id);

        return $register->toArray();
    }

    public function findOrFail(int $id): ?array
    {
        $register = $this->model->findOrFail($id);

        return $register->toArray();
    }

    public function updateOrCreate(array $require, array $data): ?array
    {
        $register = $this->model->updateOrCreate($require, $data);

        return $register->toArray();
    }

    public function create(array $data): ?array
    {
        $register = $this->model->create($data);

        return $register?->toArray();
    }

    public function update(int $id, array $data): ?array
    {
        $register = $this->model->findOrFail($id);
        $register->fill($data);
        $register->save();

        return $register->toArray();
    }

    public function delete(int $id): ?array
    {
        $register = $this->model->findOrFail($id);
        $register->delete();

        return $register->toArray();
    }
}
