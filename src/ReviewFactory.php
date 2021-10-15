<?php

namespace MohamedReda\Reviewable;

use MohamedReda\Reviewable\Models\Review;
use Illuminate\Database\Eloquent\Model;

class ReviewFactory
{
    /**
     * Create a review model and all associative relationships.
     *
     * @param Model  $model
     * @param int    $score
     * @param string $body
     * @param Model  $author
     *
     * @return Review
     */
    public static function create(Model $model, $score, $body = null, Model $author = null)
    {
        if (!$author) {
            $author = \Auth::user();
        }

        $review = Review::where([
            'author_id' => $author->id,
            'reviewable_id' => $model->id,
            'reviewable_type' => get_class($model),
        ])->firstOrNew(compact('body', 'score'));
        if ($review->exists) {
            $review->update(compact('body', 'score'));
        }
        $review->author()->associate($author);

        $review->reviewable()->associate($model);

        $review->save();

        return $review;
    }
}
