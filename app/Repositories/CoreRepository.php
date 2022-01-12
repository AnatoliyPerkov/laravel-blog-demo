<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepository
 * @package App\Repositories
 */

abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor
     */

    public function __construct()
    {
        $this->model=app($this->getModelClass());
    }

    /**
     * @return mixed
     */



    /**
     * @return Model|\Illuminate\Foundation\Application|mixed
     */

    protected function startConditions()
    {
        return clone $this->model;
    }

}
