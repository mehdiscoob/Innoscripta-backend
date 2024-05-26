<?php

namespace App\Services\Article;


use App\Models\Article;
use App\Repositories\Article\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
    protected ArticleRepositoryInterface $articleRepository;

    /**
     * Constructor
     *
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Get all articles or search based on filters.
     *
     * @param array $filters
     * @return array
     */
    public function getAll(array $filters = []): array
    {
        return $this->articleRepository->getAll($filters);
    }

    /**
     * Get an article by its ID.
     *
     * @param int $id
     * @return Article|null
     */
    public function getById(int $id): ?Article
    {
        return $this->articleRepository->getById($id);
    }

    /**
     * Create a new article.
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        return $this->articleRepository->create($data);
    }

    /**
     * Update an existing article.
     *
     * @param int $id
     * @param array $data
     * @return Article
     */
    public function update(int $id, array $data): Article
    {
        return $this->articleRepository->update($id, $data);
    }

    /**
     * Delete an article.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->articleRepository->delete($id);
    }
}
