@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Categories</h2>
            </div>
            <div class="pull-right">
                @can('category-create')
                    <a class="btn btn-success mb-3" href="{{ route('categories.create') }}"> Create New Category</a>
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
            <th>Name</th>
            <th>Slug</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($categories as $category)
            <tr>
                <td>{{ ++$i }}</td>
                <td>
                    @for ($i = 0; $i < $category->depth; $i++) &mdash; @endfor
                    <a href="{{route('categories.show', $category->id)}}">{{ $category->name }}</a>
                </td>
                <td>{{ $category->slug }}</td>
                <td>
                    <div class="d-flex flex-row mb-3">
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-info mr-1">Show</a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary mr-1">Edit</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
