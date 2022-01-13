<?php

namespace App\Http\Controllers\Blog\Cabinet;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\UseCases\Posts\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CabinetPostController extends BaseController
{
    /**
     * @return Response
     * @var $categoryRepository
     * @var $postRepository
     * @package App\Http\Controllers\Blog\Cabinet
     */

    private $postRepository;
    private $categoryRepository;
    private $service;

    function __construct()
    {
        parent::__construct();
        $this->service = app(PostService::class);
        $this->categoryRepository = app(CategoryRepository::class);
        $this->postRepository = app(PostRepository::class);

        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    public function index()
    {

        $posts = Post::forUser(Auth::user())->orderByDesc('id')->paginate(20);

        return view('cabinet.posts.index', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create()
    {
        $categories = Category::defaultOrder()->withDepth()->get();
        return view('cabinet.posts.create', compact('categories'));
    }

    /**
     * @param PostStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PostStoreRequest $request)
    {
        try {
            $post = $this->service->create($request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.posts.show', $post);

    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        try {
            $this->service->update($post->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('cabinet.posts.index')
            ->with(['success' => 'Successful save!']);
    }


    public function edit(Post $post)
    {
        $post = $this->postRepository->getPost($post->id);

        $categories = Category::defaultOrder()->withDepth()->get();

        if (!empty($post)){
            return view('cabinet.posts.edit',compact('post','categories'));
        }else{
            abort(404);
        }

    }

    public function show(Post $post)
    {
        $categories = Category::get()->toTree();

        return view('post-details-show', compact('post','categories'));
    }

    public function destroy($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->back()
            ->with(['success' => 'Successful deleted!']);
    }
}
