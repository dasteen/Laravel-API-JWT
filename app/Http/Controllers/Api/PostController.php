<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Lib\Facades\Response;
use App\Post;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class PostController extends Controller
{
    protected $fields = [
        'title',
        'text',
    ];

    public function index()
    {
        $posts = Post::get();
        return Response::sendJson(compact('posts'));
    }

    public function show(Post $post)
    {
        return Response::sendJson(compact('post'));
    }

    public function store(PostCreateRequest $request)
    {
        $input = $request->only($this->fields);

        $token_info = json_decode(JWTAuth::getPayload(), true);
        $user = User::findOrFail($token_info['sub']);
        $input['creator_id'] = $user->id;

        $post = Post::create($input);

        return Response::sendJson(compact('post'));
    }

    public function destroy(Post $post)
    {
        $token_info = json_decode(JWTAuth::getPayload(), true);
        $user = User::findOrFail($token_info['sub']);

        if($user->hasRole('administrator') || $user->id == $post->creator_id){
            $post->delete();
            return Response::sendJson(['message' => 'Пост удален']);
        }
        else {
            return Response::sendJson(['message' => 'Недостаточно прав'], [], 403);
        }
    }
}
