<?php

namespace Modules\Features\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Post\Entities\Post;
use Modules\Features\Entities\Like;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param Request $post
     * @return Response
     */
    public function store(Request $request, Post $post)
    {        
        $like = Like::create([
                'user_id' => $request->user()->id,
                'post_id'=> $post->id
            ]);

        $like->save();
      
        return response()->json($like->toArray(), Response::HTTP_CREATED);
    }
}
