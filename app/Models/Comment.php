<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user_comment() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post_comment() {
        return $this->belongsTo(BlogPost::class, 'post_id', 'id');
    }

}
