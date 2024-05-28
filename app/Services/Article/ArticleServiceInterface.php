<?php

namespace App\Services\Article;


use App\Models\Article;

interface ArticleServiceInterface
{
    /**
     * Get all articles or search based on filters.
     *
     * @param array $filters
     * @param int $perPage
     * @param int|null $page
     * @param bool $strict
     * @return array
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

    /**
     * Get a personalized news feed for the authenticated user based on preferences.
     *
     * @return array
     */
    public function getPersonalizedFeed(): array;
}
