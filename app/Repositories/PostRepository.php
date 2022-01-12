<?php

namespace App\Repositories;

use App\Models\Post as Model;

class PostRepository extends CoreRepository
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

    public function getPost($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getAllWithPaginate($perPage=null)
    {
        $columns = [
            'id',
            'title',
            'slug',
            'content',
            'status',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id','DESC')
            ->with(['user:id,name','category:id,name'])
            ->paginate($perPage);
        return $result;
    }


    public function getActivePostsWithPaginate($perPage=null)
    {
        $columns = [
            'id',
            'title',
            'slug',
            'content',
            'photo_name',
            'photo_path',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id','DESC')
            ->with(['user:id,name','category:id,name'])
            ->where('status','active')
            ->paginate($perPage);
        return $result;
    }

    public function getActivePostsForCategory($perPage=null, $categoryId)
    {
        $columns = [
            'id',
            'title',
            'slug',
            'content',
            'photo_name',
            'photo_path',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id','DESC')
            ->with(['user:id,name','category:id,name'])
            ->where('status','active')
            ->where('category_id',$categoryId)
            ->paginate($perPage);
        return $result;
    }
}
