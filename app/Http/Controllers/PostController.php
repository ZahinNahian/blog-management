<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use App\Models\PostTag;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function CreatePostPage() {
        return Inertia::render('CreatePostPage');
    } // End Method

    public function CreatePost(Request $request) {
        DB::beginTransaction();
        try {
            $user_id=$request->header('id');
            $incomingdata=$request->validate([
                'title'=>'required',
                'content'=>'required',
                'image'=>['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
                'visibility'=>'required',
            ]);
            if ($request->hasFile('image')) {
                $image=$request->file('image');
                $extension=$image->getClientOriginalExtension();
                $rename=rand(1, 9999999999999999).'.'.$extension;
                $path="uploads/post_images/";
                $image->move(public_path($path), $rename);
                $incomingdata['image']=$path.$rename;
            }
            $incomingdata['user_id']=$user_id;
            $post=Post::create($incomingdata);
            $tagsString=$request->tags;
            $tags=array_map('trim', explode(",", $tagsString));
            foreach ($tags as $tagName) {
                $tagData=['name'=>strtolower($tagName)];
                $tag_row=Tag::firstOrCreate($tagData);
                // $tag_id=$tag_row->id;
                // $postTagData=[
                //     'tag_id'=>$tag_id,
                //     'post_id'=>$post->id
                // ];
                // PostTag::create($postTagData);
                $post->tags()->attach($tag_row->id);
            }
            DB::commit();
            $data=['status' => true, 'message'=>'Post Added Successfully'];
            return redirect('/feed-page')->with('flash', $data);
        } catch (Exception $e) {
            DB::rollBack();
            $data=['status' => false, 'message'=>$e->getMessage()];
            return redirect('/feed-page')->with('flash', $data);
        }

    } // End Method

    public function ViewPost(Request $request, $id) {
        $post=Post::with('tags', 'CommentsOfThePost.UserInfoThatCommented')->where('id', $id)->first();

        // Group comments by parent_id
        $groupedComments = $post->CommentsOfThePost->groupBy('parent_id');

        // dd($groupedComments);

        return Inertia::render('ViewPost', ['post'=>$post, 'groupedComments'=>$groupedComments]);
    } //End Method

    public function PostLike(Request $request, Post $id) {
        $user_id=$request->header('id');
        $id->UsersWhoLikedThePost()->attach($user_id);
        // return redirect('/feed-page');
        return back();

    } //End Method
    
    public function PostUnlike(Request $request, Post $id) {
        $user_id=$request->header('id');
        $id->UsersWhoLikedThePost()->detach($user_id);
        // return redirect('/feed-page');
        return back();
    } //End Method

    public function Bookmark(Request $request, Post $id) {
        $user_id=$request->header('id');
        $id->UsersThatBookmarkedThePost()->attach($user_id);
        // return redirect('/feed-page');
        return back();
    } //End Method
    
    public function UnBookmark(Request $request,Post $id) {
        $user_id=$request->header('id');
        $id->UsersThatBookmarkedThePost()->detach($user_id);
        // return redirect('/feed-page');
        return back();
    } //End Method

    public function MyPostPage(Request $request) {
        $user_id=$request->header('id');
        $posts=Post::with('tags', 'UsersWhoLikedThePostMod')->where('user_id', $user_id)->latest()->get();
        // dd($posts);
        return Inertia::render('MyPostPage', ['posts'=> $posts]);
    } //End Method

    public function BookmarksPage(Request $request) {
        $user_id=$request->header('id');
        $user = User::find($user_id);
        $posts = $user->PostsBookmarkedByTheUser;    
        return Inertia::render('BookmarksPage', ['posts'=> $posts]);
    } //End Method

    public function PostDelete(Request $request, $id) {
        try {
            $user_id=$request->header('id');

            $post=Post::where('id', $id)->where('user_id', $user_id)->first();
            $post->delete();
            $data=['status' => true, 'message'=>"Successfully deleted"];
            return back()->with('flash', $data); 
        } catch (Exception $e) {
            $data=['status' => false, 'message'=>$e->getMessage()];
            return back()->with('flash', $data); 
        } 
    } //End Method

    public function EditPostPage(Request $request, Post $id) {
        $user_id=$request->header('id');
        // dd([$id->user_id, $user_id]);
        if ($id->user_id != $user_id) {
            $data=['status'=>'false', 'message'=>"You can not Edit the post"];
            return redirect('/bookmarks-page')->with('flash', $data);
        }
        $tags=$id->tags()->pluck('name')->toArray();
        $tagString=implode(', ', $tags);
        return Inertia::render('EditPostPage', ['post'=>$id, 'tags'=>$tagString]);

    } //End Method

    public function EditPost(Request $request, Post $id) {
        DB::beginTransaction();
        try {
            $user_id=$request->header('id');

            if ($id->user_id != $user_id) {
                // Ensure that the user is the owner of the post
                return redirect('/feed-page')->with('flash', ['status' => false, 'message' => 'You can not edit the post']);
            }

            $incomingdata=$request->validate([
                'title'=>'required',
                'content'=>'required',
                'image'=>['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
                'visibility'=>'required',
            ]);
            if ($request->hasFile('image')) {
                if ($id->image && file_exists(public_path($id->image))) {
                    unlink(public_path($id->image));
                }
                $image=$request->file('image');
                $extension=$image->getClientOriginalExtension();
                $rename=rand(1, 9999999999999999).'.'.$extension;
                $path="uploads/post_images/";
                $image->move(public_path($path), $rename);
                $incomingdata['image']=$path.$rename;
            }

            // Update post data
            $id->update($incomingdata);

            $tagsString=$request->tags;
            $tags=array_map('trim', explode(",", $tagsString));
            $id->tags()->detach(); // Remove existing tags

            foreach ($tags as $tagName) {
                $tagData=['name'=>strtolower($tagName)];
                $tag_row=Tag::firstOrCreate($tagData);
                $id->tags()->attach($tag_row->id);
            }
            DB::commit();
            $data=['status' => true, 'message'=>'Post Updated Successfully'];
            return redirect('/feed-page')->with('flash', $data);
        } catch (Exception $e) {
            DB::rollBack();
            $data=['status' => false, 'message'=>$e->getMessage()];
            return redirect('/feed-page')->with('flash', $data);
        }
    } // End Method

    public function AddComment(Request $request) {
        $user_id=$request->header('id');
        // $post_id=$request->post_id;
        $datafromrequest=$request->validate([
            'content'=>'required',
            'post_id'=>'required',
            'parent_id'=>'nullable'
        ]);

        $incomingdata=[
            'content'=>$request->content,
            'post_id'=>$request->post_id,
            'user_id'=>$user_id,
            'parent_id'=>$request->parent_id
        ];

        Comment::create($incomingdata);

        $data=['status' => True, 'message'=>'Comment added'];
        return back()->with('flash', $data);
        

    } //End Method
}
