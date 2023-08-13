<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function replies(Comment $comment, Request $request)
    {
        return response()->json(['status' => true, 'data' => $comment->replies()
            ->with(['user'])
            ->withCount('replies')
            ->skip($request->from)->get()]);
    }

    public function reply(Comment $comment, StoreCommentRequest $request) 
    {
        $args = $request->only($comment->getFillable());
        $args['user_id'] = auth()->id();
        $args['commentable_id'] = $comment->commentable_id;
        $args['commentable_type'] = $comment->commentable_type;
        $newComment = $comment->replies()->create($args);
        $newComment->load('user');
        
        return response()->json(['status' => true, 'data' => $newComment], 201);
    }
}