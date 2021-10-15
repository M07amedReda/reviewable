<?php

namespace MohamedReda\Reviewable;

use Illuminate\Support\ServiceProvider;
use MohamedReda\Reviewable\Contracts\Review as ReviewContract;

class ReviewableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/reviewable.php' => config_path('reviewable.php'),
        ]);

        if (!class_exists('CreateReviewsTable')) {
            $timestamp = date('Y_m_d_His', time());
            $migrationName = 'create_reviews_table.php';

            $this->publishes([
                __DIR__."/../database/migrations/{$migrationName}.stub" => $this->app->databasePath()."/migrations/{$timestamp}_{$migrationName}",
            ], 'migrations');
        }

        $this->registerModelBindings();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/reviewable.php', 'reviewable'
        );
    }

    /**
     * Register Model bindings.
     */
    protected function registerModelBindings()
    {
        $config = $this->app->config['reviewable.models'];

        $this->app->bind(ReviewContract::class, $config['review']);
    }
}
