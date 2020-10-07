<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Entities\Comment;
use App\Models\Entities\Event;
use App\Services\Event\EventFacade;
use App\Transformers\EventsTransformer;
use Illuminate\Http\Request;

class CommentsController extends BaseController
{
    /**
     * Get all active comments
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\TransformerException
     */
    public function getAll() {
        $items = Comment::where('is_active', true)->get();

        if($items->count())
            return $this->success($items);

        return $this->error('COMMENT_ERRORS', 'NO_COMMENTS');
    }
    /**
     * Get comments by eventId
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\TransformerException
     */
    public function getCommentsByEventId(Request $request) {
        $event = Event::find($request->get('event_id'));
        $comments = $event->comments()->where('is_active', true)->get();
        if(!$comments->count())
            return $this->error('COMMENT_ERRORS', 'COMMENTS_NOT_FOUND');

        return $this->success($comments);
    }

    /**
     * Delete comment by id
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\TransformerException
     */
    public function delete(Request $request) {
        $comment = Comment::find($request->get('comment_id'));
        if($comment){
            $comment->delete();
            return $this->success(['msg' => 'Comment deleted successfully']);
        }

        return $this->error('COMMENT_ERRORS', 'COMMENTS_NOT_FOUND');
    }

    /**
     * Create comment
     *
     * @param CreateCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\TransformerException
     */
    public function create(CreateCommentRequest $request) {
        $comment = Comment::create($request->only('title', 'content', 'is_active'));
        if($comment)
            return $this->success(['msg' => 'Comment created successfully']);

        return $this->error('COMMENT_ERRORS', 'COMMENTS_NOT_CREATED');
    }

    /**
     * Update isActive comment
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\TransformerException
     */
    public function updateIsActive(Request $request) {
        $comment = Comment::find($request->get('comment_id'));
        if($comment){
            $comment->is_active = !$comment->is_active;
            $comment->save();
            return $this->success(['msg' => 'Comment isActive toggled successfully']);
        }

        return $this->error('COMMENT_ERRORS', 'COMMENTS_NOT_UPDATED');
    }
}
