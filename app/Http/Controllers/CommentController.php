<?php

namespace App\Http\Controllers;

use App\Events\CommentMessage;
use App\Events\CreateCommentMessage;
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
            $comment = $this->commentService->create($request->all());
            $comment->load(['ticket', 'user.roles', 'files']);
            CreateCommentMessage::dispatch($comment, $request->ticket_id);
            return $comment;
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
            $comment = $this->commentService->update($id, $request->all());
            CommentMessage::dispatch($this->show($id), $request->ticket_id);
            return $comment;
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $comment = $this->commentService->findOrFail($id);
            CommentMessage::dispatch(["message" => "deleted", "id" => $id], $comment->ticket_id);
            return $this->commentService->delete($id);
        });
    }
}
