<?php

namespace App\Repositories\Article;

use App\Models\Article;

interface ArticleRepositoryInterface
{
    /**
     * Retrieve articles with optional filters.
     *
     * @param array $filters The filters to apply.
     * @param int $perPage Number of articles per page.
     * @param int|null $page The page number.
     * @param bool $strict Whether to apply strict filtering.
     * @return array The filtered articles.
     */
    public function getArticles(array $filters = [], int $perPage = 10, ?int $page = null, bool $strict = true): array;

    /**
     * Get an article by its ID.
     *
     * @param int $id
     * @return Article|null
     */
    public function getById(int $id): ?Article;

    /**
     * Create a new article.
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article;

    /**
     * Update an existing article.
     *
     * @param int $id
     * @param array $data
     * @return Article
     */
    public function update(int $id, array $data): Article;

    /**
     * Delete an article.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
