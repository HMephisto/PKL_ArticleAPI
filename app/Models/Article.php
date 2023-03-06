<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'thumbnail',
        'user_id',
    ];
    
    public function likes()
    {
        return $this->belongsToMany(User::class, 'article_likes');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
