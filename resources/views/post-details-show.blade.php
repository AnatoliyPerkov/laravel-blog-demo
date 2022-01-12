@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="col-lg-3 d-flex pl-0 align-items-baseline">
                <a class="btn btn-primary mb-3 m-1" href="{{ route('cabinet.posts.index') }}"> Back</a>
                @can ('post-moderation')
                    @if ($post->isOnModeration())
                        <form method="POST" action="{{ route('admin.posts.moderate', $post) }}" class="mr-1">
                            @csrf
                            <button class="btn btn-success m-1">Moderate</button>
                        </form>
                    @endif

                    @if ($post->isOnModeration() || $post->isActive())
                        <a href="{{ route('admin.posts.reject', $post) }}" class="btn btn-danger mr-1">Reject</a>
                    @endif
                @endcan

                @can ('post-edit', $post)
                    <div>
                        @if ($post->isDraft())
                            <form method="POST" action="{{ route('cabinet.posts.send', $post) }}" class="mr-1">
                                @csrf
                                <button class="btn btn-success m-1">Publish</button>
                            </form>
                        @endif
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <!-- Page content-->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Post content-->
            <article>
                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1">{{$post->title}}</h1>
                    <!-- Post meta content-->
                    <div class="text-muted fst-italic mb-2">
                        {{$post->published_at ? \Carbon\Carbon::parse($post->published_at)->isoFormat('MMMM Do YYYY, h:mm:ss a') : ''}}
                        Author: {{$post->user->name}}</div>
                    <!-- Post categories-->
                </header>
                <!-- Preview image figure-->
                @if(!empty($post->photo_path) && !empty($post->photo_name))
                    <figure class="mb-4">
                        <img alt="photo" class="img-fluid rounded" width="710" height="auto" src="{{asset('storage/' . $post->photo_path)}}" />
                    </figure>
                @endif
                <!-- Post content-->
                <section class="mb-5">
                    <p class="fs-5 mb-4">{!! $post->content !!}</p>
                </section>
            </article>
            <!-- Comments section-->
            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <!-- Comment form-->
                        <form class="mb-4"><textarea class="form-control" rows="3" placeholder="Join the discussion and leave a comment!"></textarea></form>
                        <!-- Comment with nested comments-->
                        <div class="d-flex mb-4">
                            <!-- Parent comment-->
                            <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                            <div class="ms-3">
                                <div class="fw-bold">Commenter Name</div>
                                If you're going to lead a space frontier, it has to be government; it'll never be private enterprise. Because the space frontier is dangerous, and it's expensive, and it has unquantified risks.
                                <!-- Child comment 1-->
                                <div class="d-flex mt-4">
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">Commenter Name</div>
                                        And under those conditions, you cannot establish a capital-market evaluation of that enterprise. You can't get investors.
                                    </div>
                                </div>
                                <!-- Child comment 2-->
                                <div class="d-flex mt-4">
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">Commenter Name</div>
                                        When you put money directly to a problem, it makes a good headline.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('right-nav')
    </div>
</div>

@endsection
