<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User as Model;
use Spatie\Permission\Models\Role;


class UserRepository extends CoreRepository
{
    /**
     * @return string
     */

    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param int $id
     * @return Model
     */

    public function getUser($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * @return Collection
     */

    public function getUserSelect()
    {
        $columns = implode(',',[
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at'
        ]);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;

    }

    public function getAllWithPaginate($perPage=null)
    {
        $columns=[
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at'
        ];
        $result=$this
            ->startConditions()
            ->select($columns)
            ->with('posts')
            ->paginate($perPage);

        return $result;
    }


    public function getRoles(){

        $result=Role::pluck('name','name')->all();

        return $result;
    }



}
