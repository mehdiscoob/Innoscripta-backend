<?php

namespace App\Repositories\Article;


use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{

    /**
     * Get all articles with optional filters.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters): LengthAwarePaginator;

    /**
     * Find an article by its ID.
     *
     * @param int $id
     * @return Article
     */
    public function find(int $id): Article;
}
