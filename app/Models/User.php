<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_pic'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

    public function posts() {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function PostsLikedByTheUser() {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }

    public function PostsBookmarkedByTheUser() {
        return $this->belongsToMany(Post::class, 'bookmarks', 'user_id', 'post_id');
    }

    public function PostsBookmarkedByTheUserMod() {
        return $this->belongsToMany(Post::class, 'bookmarks', 'user_id', 'post_id');
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    // public function comments() {
    //     return $this->hasMany(Comment::class, 'user_id');
    // }

    public function CommentsofTheUser() {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}
