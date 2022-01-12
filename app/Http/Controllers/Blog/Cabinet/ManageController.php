<?php

namespace App\Http\Controllers\Blog\Cabinet;

use App\Models\Post;
use App\UseCases\Posts\PostService;
use function app;
use function back;
use function redirect;

class ManageController extends BaseController
{
    private $service;

    function __construct()
    {
        parent::__construct();
        $this->service = app(PostService::class);

        $this->middleware('permission:post-moderation', ['only' => ['moderation']]);
    }

    public function send(Post $post)
    {
        try {
            $this->service->sendToModeration($post->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.posts.show', $post);
    }

}
