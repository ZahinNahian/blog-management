<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
        'user_id',
        'post_id',
        'parent_id',
        'content',
    ];

    public function UserInfoThatCommented() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function PostWhereTheCommentIs() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
