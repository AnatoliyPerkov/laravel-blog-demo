@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Post</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary mb-3" href="{{ route('admin.posts.index') }}"> Back</a>
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
    <form action="{{ route('cabinet.posts.store')  }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" class="form-control" placeholder="Title">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Slug:</strong>
                    <input type="text" name="slug" class="form-control" placeholder="Slug">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                        <select name="category_id" class="form-control form-control-lg">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">@for($i = 0; $i < $category->depth; $i++) &mdash; @endfor
                                {{$category->name}}
                            </option>

                            @endforeach
                        </select>
                </div>
            </div>
            <div class="mb-2 pl-3">
                <div class="text-muted d-flex mb-2">Add photo:</div>
                <div class="photo-pre">
                    <img id="ImgPreview" src="" class="preview1" />
                    <button type="button" id="removeImage1" value="x" class="close btn-rmv1" data-dismiss="alert">&times;</button>
                </div>
                <div class="photo">
                    <span class="btn_upload">
                      <input type="file" id="imag" name="photo" class="input-img"/>
                      Choose Image
                      </span>
                </div>
                <small class="form-text text-muted mb-3 p-0">
                    max size: 10KB ('png', 'jpeg', 'jpg','svg),
                </small>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Details:</strong>
                    <textarea class="form-control" style="height:150px" name="content" placeholder="Details"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>

@endsection

@push('scripts')
    <script src="{{asset('js/image-pre-loaded.js')}}"></script>
@endpush
