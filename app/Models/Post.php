<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=[
        'user_id',
        'title',
        'content',
        'image',
        'visibility'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function UsersWhoLikedThePost() {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }    
    
    public function UsersWhoLikedThePostMod() {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->select('users.id', 'users.username');
    }

    public function UsersThatBookmarkedThePost() {
        return $this->belongsToMany(User::class, 'bookmarks', 'post_id', 'user_id');
    }    
    
    public function UsersThatBookmarkedThePostMod() {
        return $this->belongsToMany(User::class, 'bookmarks', 'post_id', 'user_id')->select('users.id');
    }

    public function CommentsOfThePost() {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

}
