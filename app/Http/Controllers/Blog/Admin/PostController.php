<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\PostRejectRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\UseCases\Posts\PostService;
use Illuminate\Http\Response;


class PostController extends BaseController
{
    /**
     * @return Response
     * @var $postRepository
     * @package App\Http\Controllers\Blog\Admin
     */

    private $postRepository;
    private $service;

    function __construct()
    {
        parent::__construct();
        $this->service = app(PostService::class);
        $this->postRepository = app(PostRepository::class);

    }


    public function index()
    {
        $posts = $this->postRepository->getAllWithPaginate(5);

        if (empty($posts)){

           return redirect()->route('admin.posts.create');
        }

        return view('admin.posts.index', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function moderate(Post $post)
    {
        try {
            $this->service->moderate($post->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.posts.show', $post);
    }


    public function formReject(Post $post)
    {
       return view('admin.posts.reject',compact('post'));
    }


    public function reject(PostRejectRequest $request, Post $post)
    {
        try {
            $this->service->reject($post->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.posts.show', $post);
    }


}
