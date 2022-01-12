<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @var $blogPostRepository
     * @package App\Http\Controllers\Blog
     */

    private $blogPostRepository;
    private $blogCategoryRepository;

    public function __construct()
    {
        $this->blogPostRepository = app( PostRepository::class );
        $this->blogCategoryRepository = app( CategoryRepository::class);

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     *
     */

    public function index()
    {
        $posts = $this->blogPostRepository->getActivePostsWithPaginate(5);
        $categories = Category::get()->toTree();

        return view('index',compact('posts','categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function postShow(Post $post)
    {
        $categories = Category::get()->toTree();

        return view('post-details-show', compact('post','categories'));

    }

    public function postsForCategory(Category $category)
    {
        $posts = $this->blogPostRepository->getActivePostsForCategory(5,$category->id);
        $categories = Category::get()->toTree();

        if ($posts->isEmpty())
        {
            return view('index',compact('posts','categories'))
                   ->withErrors(['massage'=>'Posts not found!']);
        }
        return view('index',compact('posts','categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);


    }

}
