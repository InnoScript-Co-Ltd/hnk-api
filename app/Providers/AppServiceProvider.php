<?php

namespace App\Providers;

use App\Helpers\QueryBuilderHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(255);

        $this->registerBlueprintMacros();
        $this->registerQueryBuilderMacros();
    }

    private function registerBlueprintMacros()
    {

        Blueprint::macro('auditColumns', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->unsignedBigInteger('deleted_by')->nullable();
            $this->timestamps();
            $this->softDeletes();

            return $this;
        });
    }

    private function registerQueryBuilderMacros()
    {
        Builder::macro('sortingQuery', function () {
            return QueryBuilderHelper::sortingQuery($this);
        });

        Builder::macro('searchQuery', function () {
            return QueryBuilderHelper::searchQuery($this);
        });

        Builder::macro('paginationQuery', function () {
            return QueryBuilderHelper::paginationQuery($this);
        });

        Builder::macro('filterQuery', function () {
            return QueryBuilderHelper::filterQuery($this);
        });

        Builder::macro('filterDateQuery', function () {
            return QueryBuilderHelper::filterDateQuery($this);
        });
    }
}
