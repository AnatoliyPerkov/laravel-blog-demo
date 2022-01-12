<?php

namespace App\UseCases\Categories;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    /**
     * @var Category $category
     * @var CategoryRepository $categoryRepository
     */

    private $categoryRepository;

    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
    }

    public function create(CategoryStoreRequest $request)
    {

        $category = Category::create([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent'],
        ]);

        return $category;

}

    public function update($id, CategoryUpdateRequest $request): void
    {
        $category = $this->categoryRepository->getCategory($id);

        $category->update([
            'name' => $request['name'],
            'slug' => $request['slug'],
            'parent_id' => $request['parent'],
        ]);
    }

    public function remove($id): void
    {
        $category = $this->categoryRepository->getCategory($id);
        $category->delete();
    }

}
