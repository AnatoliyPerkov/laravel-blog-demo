<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Spatie\Permission\Models\Role;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});
Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Login', route('login'));
});
Breadcrumbs::for('register', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Register', route('register'));
});


// Home
Breadcrumbs::for('details.post.show', function (BreadcrumbTrail $trail, Post $post) {
    $trail->parent('home');
    $trail->push('Post', route('details.post.show',$post));
});

//Home > Manage posts
Breadcrumbs::for('admin.posts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Manage posts', route('admin.posts.index'));
});

//Admin > Users
Breadcrumbs::macro('resource', function (string $name, string $title) {
    // Home > Users
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('home');
        $trail->push($title, route("{$name}.index"));
    });

    // Home > Users > New
    Breadcrumbs::for("{$name}.create", function (BreadcrumbTrail $trail) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push('New', route("{$name}.create"));
    });

    // Home > Users > User 123
    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, User $user) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push($user->name, route("{$name}.show", $user));
    });

    // Home > Users > User 123 > Edit
    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, User $user) use ($name) {
        $trail->parent("{$name}.show", $user);
        $trail->push('Edit', route("{$name}.edit", $user));
    });


});
Breadcrumbs::resource('users', 'Users');

//Admin > Categories
Breadcrumbs::macro('resource', function (string $name, string $title) {
    // Home > Categories
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('home');
        $trail->push($title, route("{$name}.index"));
    });

    // Home > Categories > New
    Breadcrumbs::for("{$name}.create", function (BreadcrumbTrail $trail) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push('New', route("{$name}.create"));
    });

    // Home > Categories > Category 123
    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, Category $category) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push($category->name, route("{$name}.show", $category));
    });

    // Home > Categories > Category 123 > Edit
    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, Category $category) use ($name) {
        $trail->parent("{$name}.show", $category);
        $trail->push('Edit', route("{$name}.edit", $category));
    });
});
Breadcrumbs::resource('categories', 'Categories');

//Admin > Roles
Breadcrumbs::macro('resource', function (string $name, string $title) {
    // Home > Roles
    Breadcrumbs::for("{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
        $trail->parent('home');
        $trail->push($title, route("{$name}.index"));
    });

    // Home > Roles > New
    Breadcrumbs::for("{$name}.create", function (BreadcrumbTrail $trail) use ($name) {
        $trail->parent("{$name}.index");
        $trail->push('New', route("{$name}.create"));
    });

    // Home > Roles > Role 123
    Breadcrumbs::for("{$name}.show", function (BreadcrumbTrail $trail, $id) use ($name) {
        $role = Role::find($id);
        $trail->parent("{$name}.index");
        $trail->push($role->name, route("{$name}.show", $role));
    });

    // Home > Roles > Role 123 > Edit
    Breadcrumbs::for("{$name}.edit", function (BreadcrumbTrail $trail, $id) use ($name) {
        $role = Role::find($id);
        $trail->parent("{$name}.index");
        $trail->push('Edit', route("{$name}.edit", $role));
    });
});

Breadcrumbs::resource('roles', 'Roles');


//Category
Breadcrumbs::for('posts.category.show', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('home');

    foreach ($category->ancestors as $ancestor) {
        $trail->push($ancestor->name, route('posts.category.show', $ancestor));
    }

    $trail->push($category->name, route('posts.category.show', $category));
});

//Cabinet
Breadcrumbs::for('cabinet.posts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Posts', route('cabinet.posts.index'));
});
Breadcrumbs::for('cabinet.posts.create', function (BreadcrumbTrail $trail) {
    $trail->parent('cabinet.posts.index');
    $trail->push('Create', route('cabinet.posts.create'));
});
Breadcrumbs::for('cabinet.posts.edit', function (BreadcrumbTrail $trail, Post $post) {
    $trail->parent('cabinet.posts.index');
    $trail->push('Edit', route('cabinet.posts.edit',$post));
});
Breadcrumbs::for('cabinet.posts.show', function (BreadcrumbTrail $trail, Post $post) {
    $trail->parent('cabinet.posts.index');
    $trail->push($post->title, route('cabinet.posts.show',$post));
});
