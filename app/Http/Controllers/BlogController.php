<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function FeedPage(Request $request) {
        // $email=$request->header('email');

        $search = $request->input('search');

        $id=$request->header('id');

        $posts = Post::with(['tags', 'UsersWhoLikedThePostMod', 'UsersThatBookmarkedThePostMod', 'user'])
        ->where('user_id', '!=', $id)
        ->where('visibility', 'public')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('tags', function ($tagQuery) use ($search) {
                      $tagQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('username', 'like', "%{$search}%");
                  });
            });
        })
        ->latest()
        ->get();
        // $posts=Post::with('tags', 'UsersWhoLikedThePostMod', 'UsersThatBookmarkedThePostMod')->where('user_id','!=', $id)->where('visibility', 'public')->latest()->get();
        // dd($posts);
        return Inertia::render('BlogPage', ['posts'=>$posts]);
    } //End Method    
    
    
    public function BlogPageNu(Request $request) {

        $search = $request->input('search');

        $posts=Post::with('tags')->where('visibility', 'public')->latest()->get();
        // dd($posts);
        return Inertia::render('BlogPageNu', ['posts'=>$posts]);
    } //End Method


}
