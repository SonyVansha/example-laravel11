<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
// Routes Model class
use App\Models\Post;
use App\Models\User;

Route::get('/', function () {
    return view('home', [ 'title' => 'Home Page']);
});

// Route Blog
Route::get('/posts', function () {

    // Menanampilkan data yang terbaru pertama kali
    // $posts = Post::latest();

    // get post on lastest and will return
    // $posts = Post::with(['author', 'category'])->latest()->get();

    // Search post by title
    // if (request('search')) {
        
    //     $posts = Post::where('title', 'like', '%' . request('search') . '%');
    // }

    return view('posts', [ 'title' => 'Blog Page', 'posts' => Post::filter(request(['search', 'category', 'author']))->latest()->paginate(5)->withQueryString()]);
});

// Route Single Post by slug
Route::get('/posts/{post:slug}', function (Post $post) {

    // Mencari arry pertama kali ketemu
    // $post = Post::find($slug);

    return view('post', [ 'title' => 'Single Post', 'post' => $post]);
});

// Route Single Post by Author name
Route::get('/authors/{user:username}', function (User $user) {
    // load data post by author and category 
    // $posts = $user->posts->load('category', 'author');
    
    return view('posts', [ 'title' => count($user->posts) . ' Articles by ' . $user->name, 'posts' => $user->posts]);
});


Route::get('/categories/{category:slug}', function (Category $category) {
    // $posts = $category->posts->load('category', 'author');
    
    return view('posts', [ 'title' => 'Articles in: '. $category->name, 'posts' => $category->posts]);
});

// Route About
Route::get('/about', function () {
    return view('about', [ 'name' => 'Sony Vansha', 'title' => 'About Page']);
});

Route::get('/contact', function () {
    return view('contact', [ 'title' => 'Contact Page']);
});

Route::get('/docs', function () {
    return view('welcome');
});
