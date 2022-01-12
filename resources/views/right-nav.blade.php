<!-- Side widgets-->
<div class="col-lg-4">
    <!-- Search widget-->
    <div class="card mb-4">
        <div class="card-header">Search</div>
        <div class="card-body">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                <button class="btn btn-primary" id="button-search" type="button">Go!</button>
            </div>
        </div>
    </div>
    <!-- Categories widget-->
    <div class="card mb-4">
        <div class="card-header">Categories</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <div class="card">
                        <div class="row">
                            <ul id="nav">
                                @foreach($categories as $category)
                                        <li><a href="{{route('posts.category.show', $category)}}">{{ $category->name }}</a>
                                            <span hidden>{{$category->loadCount('posts')}}</span>
                                            <span>( {{$category->posts_count}} )</span>
                                            @foreach($category->children as $subCategories)
                                                <ul>
                                                    <li>
                                                        <a href="{{route('posts.category.show', $subCategories)}}">{{ $subCategories->name }}
                                                            <span hidden>{{$subCategories->loadCount('posts')}}</span>
                                                            <span>( {{$subCategories->posts_count}} )</span>
                                                        </a>
                                                    </li>
                                                    @foreach($subCategories->children as $subCategory)
                                                        <ul>
                                                        <li>
                                                            <a href="{{route('posts.category.show', $subCategory)}}">{{$subCategory->name}}
                                                            <span hidden>{{$subCategory->loadCount('posts')}}</span>
                                                            <span>( {{$subCategory->posts_count}} )</span>
                                                            </a>
                                                        </li>
                                                        </ul>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Side widget-->
</div>
