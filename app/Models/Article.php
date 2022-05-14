<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'body', 'image', 'tags',
    ];

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function scopeviewsCount($quary)
    {
        return $quary->withCount('views')->get();
    }

    public function scopelikesCount($quary)
    {
        return $quary->withCount('likes')->get();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
