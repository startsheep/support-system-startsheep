<?php

namespace App\Http\Controllers;

use App\Events\CommentMessage;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentDetail;
use App\Http\Searches\CommentSearch;
use App\Http\Services\Comment\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        $factory = app()->make(CommentSearch::class);
        $comments = $factory->apply()->paginate($request->per_page);

        return new CommentCollection($comments);
    }

    public function store(CommentRequest $request)
    {
        return DB::transaction(function () use ($request) {
            CommentMessage::dispatch("Comment Created", $request->ticket_id);
            return $this->commentService->create($request->all());
        });
    }

    public function show($id)
    {
        $comment = $this->commentService->findOrFail($id);
        $comment->load(['ticket', 'user.roles', 'files']);

        return new CommentDetail($comment);
    }

    public function update(CommentRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            CommentMessage::dispatch("Comment Updated", $request->ticket_id);
            return $this->commentService->update($id, $request->all());
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $comment = $this->commentService->findOrFail($id);
            CommentMessage::dispatch("Comment Deleted", $comment->ticket_id);
            return $this->commentService->delete($id);
        });
    }
}
