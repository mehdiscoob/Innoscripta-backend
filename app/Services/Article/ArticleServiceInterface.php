<?php

namespace App\Services\Article;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Article;

interface ArticleServiceInterface
{
    /**
     * Get all articles with filters.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllArticles(array $filters): LengthAwarePaginator;

    /**
     * Find an article by its ID.
     *
     * @param int $id
     * @return Article
     */
    public function findArticleById(int $id): Article;
}
