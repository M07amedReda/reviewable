# laravel-reviewable

This package adds a reviewable feature to your app.

## Install
`composer require mohamedreda/reviewable`
*publish config:* `php artisan vendor:publish --provider="MohamedReda\Reviewable\ReviewableServiceProvider"`

## Usage
First, add the `MohamedReda\Reviewable\Traits\HasReviews` trait to your model you want to add reviews to.

```php
use MohamedReda\Reviewable\Traits\HasReviews;

class Post extends Model
{
    use HasReviews;

    // ...
}
```

Now you can create a review by:
```php
// from reviewable entity
Post::first()->createReview($rate = 5, $review = 'Samole Review Goes Here', $auther = Auth::user());

// author is assumed to be logged in and executing this operation
Post::first()->createReview($rate = 10);

// with helper
review($reviewable = ReviewableModel::find(1), $rate = 5, $review = 'Sample Review Goes Here', $author = Auth::user());
```

and receive review scores by:
```php
// summarizes all scores
ReviewableModel::first()->score;

// gives the average of all scores
ReviewableModel::first()->avg_score;
```

### Using your own Review-Model
To change the configuration Review-Model, just create a new Model and reference it in the `reviewable.models.review` config.