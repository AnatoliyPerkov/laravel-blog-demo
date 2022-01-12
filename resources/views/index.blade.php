@extends('layouts.app')

@section('content')

<!-- Page content-->
<div class="container">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">

        @if ($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif
            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                @foreach($posts as $post)
                <div class="col-lg-12">
                    <!-- Blog post-->
                    <div class="card mb-4">
                        @if(!empty($post->photo_path) && !empty($post->photo_name))
                        <a href="{{ route('details.post.show',$post) }}">
                            <img alt="photo" class="card-img-top"  height="auto" src="{{asset('storage/' . $post->photo_path)}}" />
                        </a>
                        @endif
                        <div class="card-body">
                            <div class="small text-muted">{{$post->published_at ? \Carbon\Carbon::parse($post->published_at)->isoFormat('MMMM Do YYYY, h:mm:ss a') : ''}}
                                Author: {{$post->user->name}}
                            </div>
                            <h2 class="card-title h4">{{$post->title}}</h2>
                            <p class="card-text">
                                {!!mb_substr(strip_tags($post->content), 0, 200)!!}...
                            </p>
                            <a class="btn btn-primary" href="{{ route('details.post.show',$post) }}">Read more →</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <!-- Pagination-->
            <div class="row justify-content-center">
                {{ $posts->links('pagination-links') }}
            </div>

        </div>
      @include('right-nav')
    </div>
</div>



@endsection
