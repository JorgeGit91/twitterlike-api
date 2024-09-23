<?php

namespace Modules\Features\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','post_id'];
    
    protected static function newFactory()
    {
        return \Modules\Features\Database\factories\LikeFactory::new();
    }


}
