@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Posts</h2>
            </div>
            <div class="pull-right">
                @can('post-create')
                    <a class="btn btn-success mb-3" href="{{ route('cabinet.posts.create') }}"> Create New Post</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Category</th>
            <th>Content</th>
            <th>Status</th>
            <th>Published</th>
            <th>Author</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($posts as $post)
            <tr class="@if (!$post->isActive()) bg-secondary @endif">
                <td>{{ ++$i }}</td>
                <td>{{ $post->title}}</td>
                <td>{{ $post->category->name}}</td>
                <td>
                    {!!mb_substr(strip_tags($post->content), 0, 20)!!}...
                </td>
                <td>
                    @if ($post->isDraft())
                        <span class="badge badge-secondary">Draft</span>
                    @elseif ($post->isOnModeration())
                        <span class="badge badge-primary">Moderation</span>
                    @elseif ($post->isActive())
                        <span class="badge badge-primary">Active</span>
                    @endif
                </td>
                <td>{{$post->published_at}}</td>
                <td>{{$post->user->name}}</td>
                <td>
                    <form action="{{ route('cabinet.posts.destroy',$post->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('cabinet.posts.show',$post) }}">Show</a>
                        @can('post-edit')
                            <a class="btn btn-primary" href="{{ route('cabinet.posts.edit',$post) }}">Edit</a>
                        @endcan
                        @csrf
                        @method('DELETE')
                        @can('post-delete')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="row justify-content-center">
        {{ $posts->links('pagination-links') }}
    </div>
@endsection
