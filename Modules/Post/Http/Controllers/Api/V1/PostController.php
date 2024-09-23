<?php

namespace Modules\Post\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Post\Http\Requests\CreatePostRequest;
use Modules\Post\Transformers\PostResource;
use Modules\Post\Entities\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Post\Services\PostService;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected PostService $postService
    ) {}

    /**
     * Display a listing of the resource.
     * @param int $page
     * @return Response
     */
    public function index(Request $request, ?Post $post)
    {
        return $post->exists ? new PostResource($post) : PostResource::collection(Post::paginate());
    }

    /**
     * Search posts by given string
     * @param int $page
     * @return Response
     */
    public function fuzzySearch(Request $request, string $search)
    {
        $posts = Post::whereFuzzy('text', $search)->orderByFuzzy('text')->simplePaginate();

        return response()->json(PostResource::collection($posts), Response::HTTP_CREATED);
    }

    /**
     * Create a new post
     * @param CreatePostRequest $request
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {
        $post = $this->postService->createPost($request);

        return response()->json(new PostResource($post), Response::HTTP_CREATED);
    }

    /**
     * Update the post data.
     * @param Request $request
     * @param Post $post
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update($request->all());

        $post->save();
      
        return response()->json(new PostResource($post), Response::HTTP_CREATED);
    }

    /**
     * Lists latest posts
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function latest(Request $request)
    {
        $posts = Post::latest()->take(10)->get();

        return response()->json(PostResource::collection($posts), Response::HTTP_CREATED);
    }

    /**
     * Remove given post
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        Gate::authorize('destroy', $post);

        return $post->delete() ? response()->json("OK", Response::HTTP_CREATED) : response()->json("KO", Response::HTTP_CREATED);
    }
}
