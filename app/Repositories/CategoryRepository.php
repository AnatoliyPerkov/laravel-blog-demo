<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Category as Model;


class CategoryRepository extends CoreRepository
{
    /**
     * @return string
     */

    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     *
     * @param int $id
     * @return Model
     */

    public function getCategory($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * @return Collection
     */

    public function getSelectList()
    {
        $columns = implode(',',['id','name']);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;

    }


}
