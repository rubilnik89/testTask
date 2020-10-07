<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="comments",
 *     description="Event model",
 *     type="object",
 *     title="Event model",
 *
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string", description="comment title", example="אירוע חנוכה"),
 *     @OA\Property(property="content", type="string", description="comment description", example="חג החנוכה הוא..."),
 *     @OA\Property(property="is_active", type="boolean", description="is the comment displayed in the app"),
 * )
 */
class Comment extends Model
{

    protected $table = 'comments';

    protected $fillable = [
        'title',
        'content',
        'is_active'
    ];


    /**
     * Get the events for the comment.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
