<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IBase;
use App\Repositories\Criteria\ICriteria;
use App\Traits\HttpResponse;
use Illuminate\Support\Arr;

abstract class BaseRepository implements IBase, ICriteria
{
    use HttpResponse;

    protected $model;

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    public function withCriteria(...$criteria): BaseRepository
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }
        return $this;

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
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function forceFill(array $data, $id)
    {
        $record = $this->find($id);
        $record->forceFill($data)->save();
    }
}
