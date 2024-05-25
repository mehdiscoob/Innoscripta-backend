<?php

namespace App\Services\Article;


use App\Repositories\Article\ArticleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Article;

class ArticleService implements ArticleServiceInterface
{
    protected $articleRepository;

    /**
     * ArticleService constructor.
     *
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Get all articles with filters.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllArticles(array $filters): LengthAwarePaginator
    {
        return $this->articleRepository->getAll($filters);
    }

    /**
     * Find an article by its ID.
     *
     * @param int $id
     * @return Article
     */
    public function findArticleById(int $id): Article
    {
        return $this->articleRepository->find($id);
    }
}
