@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Category</h2>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('categories.update',$category->id) }}" method="POST">
        @csrf
        @method('PUT')

            <div class="form-group">
                <label for="name" class="col-form-label">Name</label>
                <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $category->name }}" required>
                @if ($errors->has('name'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <label for="slug" class="col-form-label">Slug</label>
                <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ $category->slug }}">
                @if ($errors->has('slug'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
                @endif
            </div>
            <div class="form-group">
                <label for="parent" class="col-form-label">Parent</label>
                <select id="parent" class="form-control{{ $errors->has('parent') ? ' is-invalid' : '' }}" name="parent">
                    <option value=""></option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}"{{ $parent->id == old('parent',$category->parent_id) ? ' selected' : '' }}>
                            @for ($i = 0; $i < $parent->depth; $i++) &mdash; @endfor
                            {{ $parent->name }}
                        </option>
                    @endforeach;
                </select>
                @if ($errors->has('parent'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('parent') }}</strong></span>
                @endif
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

    </form>
@endsection
