<?php

namespace Modules\Post\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Post\Repositories\PostRepository;
use Modules\Post\Http\Requests\CreatePostRequest;

class PostService
{

        /**
     * Create a new controller instance.
     */
    public function __construct(
        protected PostRepository $postRepository
    ) {}

    /**
     * Create a new post
     * @param CreatePostRequest $request
     * @return Response
     */
    public function createPost(CreatePostRequest $request)
    {
        $file = $request->file('media_content');
        $dbfile = null;

        $post = $this->postRepository->createPost($request->user()->id, $request->text);

        if($file)
        {
            $dbfile = $file->storeAs("public/posts/$post->id", $file->getClientOriginalName());

            $valid_image =  Validator::make($request->all(),[
                'media_content' => 'mimetypes:image/*',
            ]);

            $this->postRepository->updateMedia($post->id, $valid_image->fails() ? 'video' : 'image', $dbfile);

            $post->refresh();        
        }
        
        return $post;
    }

}