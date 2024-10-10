<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'author', 'body'];

    // Load data author dan category | lazy loading
    protected $with = ['author', 'category'];

    // Pengecekan user buat post
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Pengecekan category buat post
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, fn ($query, $search) => 
            $query->where('title', 'like', '%' . $search . '%')
        );

        $query->when(
            $filters['category'] ?? false, fn ($query, $category) =>
            $query->whereHas('category', fn ($query) =>
                $query->where('slug', $category)
            )
        );

        $query->when(
            $filters['author'] ?? false, fn ($query, $author) =>
            $query->whereHas('author', fn ($query) =>
                $query->where('username', $author)
            )
        );
        // $query->where('title', 'like', '%' . request('search') . '%');
    }
}
