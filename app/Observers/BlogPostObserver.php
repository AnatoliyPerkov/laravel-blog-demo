<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     *
     * @param  Post $post
     * @return void
     */
    public function created(Post $post)
    {

    }

    public function creating(Post $post)
    {
        $this->setSlug($post);
        $this->setUser($post);

    }

    /**
     *
     * @param Post $post
     */
    public function updating(Post $post)
    {
        $this->setSlug($post);

    }

    protected function setUser(Post $post)
    {
        if (Auth::id()) {
            return $post->user_id =Auth::id();
        }
    }

    protected function setSlug(Post $post)
    {
        if (empty($post['slug'])){
            $post['slug']= Str::slug(time().'-'.$post['title']);
        }
    }

    /**
     * Handle the job post "updated" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }


    public function deleting(Post $post)
    {

    }

    /**
     * Handle the job post "deleted" event.
     *
     * @param  Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the job post "restored" event.
     *
     * @param Post $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the job post "force deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }

}
