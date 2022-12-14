<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param string $model
     * @return void
     */
    public function setModel(string $model): void
    {
        $this->model = new $model();
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
