<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IBase;
use App\Traits\HttpResponse;
use Exception;

abstract class BaseRepository implements IBase
{
    use HttpResponse;

    protected $model;

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    protected function getModelClass()
    {
        if (! method_exists($this, 'model')) {
            return self::failure('no model defined', 422);
        }

        return app()->make($this->model());
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findWhere($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    public function findWhereFirst($column, $value)
    {
        return $this->model->where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }
}
