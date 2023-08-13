<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Http\Resources\IssueCollection;
use App\Http\Resources\IssueResource;
use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $data = Issue::with(['comments.user', 'comments.replies.user'])->orderByDesc('id')->paginate(30);
        return new IssueCollection($data);
    }

    public function store(StoreIssueRequest $request)
    {
        $validated = $request->validated();
        $validated = $request->safe()->only((new Issue)->getFillable());
        
        $issue = Issue::create($validated);

        return new IssueResource($issue);
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $validated = $request->validated();
        $validated = $request->safe()->only((new Issue)->getFillable());

        $issue->update($validated);
        $issue = Issue::find($issue->id);

        return new IssueResource($issue);
    }


    public function destroy(int $id): JsonResponse
    {
        Issue::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => __('issue deleted')]);
    }

    public function createComment(Issue $issue, StoreCommentRequest $request) 
    {
        $data = $request->only((new Comment)->getFillable());
        $data['user_id'] = $request->user()->id;
        $comment = $issue->comments()->create($data);
        $comment->load('user');
        return response()->json(['status' => true, 'data' => $comment], 201);
    }

    public function getComments(Issue $issue, Request $request)
    {
        $comments = $issue->comments()
            ->with('user')
            ->with('replies', function($q){
                return $q->with('user')->withCount('replies');
            })
            ->withCount('replies')
            ->orderByDesc('id')
            ->paginate($request->perPage);
        return response()->json(['status' => true, 'data' => $comments]);
    }
}