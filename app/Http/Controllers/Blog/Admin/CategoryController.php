<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\UseCases\Categories\CategoryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class CategoryController extends BaseController
{
    /**
     * @return Response
     * @var $categoryRepository
     * @package App\Http\Controllers\Blog\Admin

     */

     private $categoryRepository;
     private $service;

    function __construct()
    {
        parent::__construct();
        $this->categoryRepository = app(CategoryRepository::class);
        $this->service = app(CategoryService::class);

    }
    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        $categories = Category::defaultOrder()->withDepth()->get();

        return view('admin.categories.index',compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $parents = Category::defaultOrder()->withDepth()->get();

        return view('admin.categories.create', compact('parents'));
    }

    /**
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        try {
            $category = $this->service->create($request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('categories.show', $category);
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function show(Category $category)
    {
        return view('admin.categories.show',compact('category'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View
     */
    public function edit(Category $category)
    {
        $parents = Category::defaultOrder()->withDepth()->get();

        return view('admin.categories.edit',compact('category','parents'));
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {

        try {
            $this->service->update($category->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('categories.index')
            ->with(['success' => 'Successful save!']);

    }

    /**
     * @param  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()
            ->with(['success' => 'Successful deleted!']);
    }

}
