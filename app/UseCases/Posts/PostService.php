<?php

namespace App\UseCases\Posts;

use App\Events\Posts\ModerationPassed;
use App\Http\Requests\PostRejectRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    /**
     * @var Post $post
     * @var PostRepository $postRepository
     */

    private $postRepository;

    public function __construct()
    {
        $this->postRepository=app(PostRepository::class);
    }

    public function create(PostStoreRequest $request)
    {

        return DB::transaction(function () use ($request) {

            $post = Post::make([
                'title'       => $request['title'],
                'content'     => $request['content'],
                'slug'        => Str::slug($request['slug']),
                'category_id' => $request['category_id'],
                'status' => Post::STATUS_DRAFT,
            ]);
            if ($request->photo) {
                $photoName = time() . '_' . $request->photo->getClientOriginalName();
                $photoPath = $request->file('photo')->storeAs('photos', $photoName, 'public');

                $post->photo_name = $photoName;
                $post->photo_path = $photoPath;
            }
            $post->saveOrFail();

            return $post;
        });
    }

    public function update($id, PostUpdateRequest $request): void
    {
        $post = $this->postRepository->getPost($id);
        $post->update([
            'title' => $request['title'],
            'content' => $request['content'],
            'slug' => Str::slug($request['slug']),
            'category_id' => $request['category_id'],
        ]);
        if (!empty($request->photo)){
            $oldPhoto=$post->photo_path;
            Storage::delete($oldPhoto);

            $photoName = time() . '_' . $request->photo->getClientOriginalName();
            $photoPath = $request->file('photo')->storeAs('photos', $photoName, 'public');

            $post->photo_name = $photoName;
            $post->photo_path = $photoPath;
            $post->update();
        }
    }


    public function sendToModeration($id): void
    {
        $post = $this->postRepository->getPost($id);
        $post->sendToModeration();
    }

    public function moderate($id): void
    {
        $post = $this->postRepository->getPost($id);
        $post->moderate(Carbon::now());
        event(new ModerationPassed($post));
    }

    public function reject($id, PostRejectRequest $request): void
    {
        $post = $this->postRepository->getPost($id);
        $post->reject($request['reason']);
    }


    public function remove($id): void
    {
        $post = $this->postRepository->getPost($id);
        $post->delete();
    }

}
