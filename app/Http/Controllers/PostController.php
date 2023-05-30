<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category', 'user')->paginate(10);

        return view('post.index', compact('posts'));
    }

    public function create()
    {
        $category = Category::all();
        return view('post.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',

        ]);

        $post = Post::create([
            'title' => $validate['title'],
            'content' => $validate['content'],
            'image' => 'https://via.placeholder.com/640x480.png/004466?text='. $validate['title'],
            'user_id' => $validate['user_id'],
            'category_id' => $validate['category_id'],
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    public function edit(string $id)
    {
        $post = Post::find($id);
        $category = Category::all();

        return view('post.edit', compact('post', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = Post::find($id);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => 'https://via.placeholder.com/640x480.png/004466?text='. $request->title,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('posts.index')->with('success', 'Article updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Post not found');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
