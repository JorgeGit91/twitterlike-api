<?php

namespace Modules\Comment\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comment\Notifications\CommentCreated;
use Modules\Comment\Entities\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Comment::paginate();
    }

    /**
     * Creates new comment
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $comment = $request->user()->comments()->create($request->all());

        $comment->save();

        //Needs SMTP config
        //$comment->post->user->notify(new CommentCreated($comment));

        return response()->json($comment->toArray(), Response::HTTP_CREATED);
    }

    /**
     * Updates the given comment
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $comment->update($request->all());

        $comment->save();
      
        return response()->json($comment->toArray(), Response::HTTP_CREATED);
    }

    /**
     * Removes the given comment
     * @param Comment $comment
     * @return Response
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('destroy', $comment);

        return $comment->delete() ? response()->json("OK", Response::HTTP_CREATED) : response()->json("KO", Response::HTTP_CREATED);

    }
}
