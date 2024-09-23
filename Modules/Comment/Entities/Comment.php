<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Modules\Post\Entities\Post;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'text',
        'post_id',
    ];

    protected $dates = ['deleted_at'];
    
    protected static function newFactory()
    {
        return \Modules\Comment\Database\factories\CommentFactory::new();
    }

    /**
     * Get the user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post for the comment
     */
    public function post(): BelongsTo
    {
        return $this->BelongsTo(Post::class);
    }
}
