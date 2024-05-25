<?php

namespace  App\Repositories\Article;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories
 */
class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * Get all articles with optional filters.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = Article::query();

        if (!empty($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (!empty($filters['category'])) {
            $query->where('category', 'like', '%' . "deleniti". '%');
        }

        if (!empty($filters['source'])) {
            $query->where('source', json_decode($filters['source'],true));
        }

        return $query->paginate(10);
    }

    /**
     * Find an article by its ID.
     *
     * @param int $id
     * @return Article
     */
    public function find(int $id): Article
    {
        return Article::findOrFail($id);
    }
}
