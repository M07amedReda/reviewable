<?php

namespace MohamedReda\Reviewable\Models;

use Illuminate\Database\Eloquent\Model;
use MohamedReda\Reviewable\Contracts\Review as ReviewContract;
use MohamedReda\Reviewable\ReviewFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model implements ReviewContract
{
    /**
     * @var Model
     */
    protected static $model;

    /**
     * @var array
     */
    protected $fillable = [
        'score',
        'body'
    ];

    /**
     * Get the author of the score.
     *
     * return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo( config('reviewable.models.author') );
    }

    /**
     * 
     * Get the reviewable item.
     * @return MorphTo
     */
    public function reviewable() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Writes a review to the database.
     *
     * @param Model      $model
     * @param int        $score
     * @param string     $body
     * @param Model|null $author
     */
    public static function write(Model $model, $score, $body = null, Model $author = null){
        ReviewFactory::create($model, $score, $body, $author);
    }
}
