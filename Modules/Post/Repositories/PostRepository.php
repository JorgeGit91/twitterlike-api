<?php

namespace Modules\Post\Repositories;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Post\Entities\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{

    /**
     * Create a new post
     * @param string $text
     * @param string $dbfile
     * @return Response
     */
    public function createPost(int $user_id,string $text, string $dbfile=null): Post
    {
        try{
            DB::beginTransaction();

            $post = Post::create([
                'text'=>$text,
                'media_content'=>$dbfile,
                'user_id'=>$user_id
            ]);   

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        
        return $post;
    }

     /**
     * Updates post media
     * @param CreatePostRequest $request
     * @return Response
     */
    public function updateMedia(int $post_id, string $media_name, string $media_content): bool
    {
        try{
            DB::beginTransaction();

            $resp = Post::find($post_id)->update([
                'media_content' => $media_content,
                'media_name' =>  $media_name
            ]);      

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        
        return $resp;
    }

}