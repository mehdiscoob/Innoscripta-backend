<?php

namespace App\Repositories\Article;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ArticleRepository
 *
 * @package App\Repositories\Article
 */
class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var Article
     */
    protected Article $articleModel;

    /**
     * ArticleRepository constructor.
     *
     * @param Article $articleModel
     */
    public function __construct(Article $articleModel)
    {
        $this->articleModel = $articleModel;
    }

    /**
     * Retrieve articles with optional filters.
     *
     * @param array $filters The filters to apply.
     * @param int $perPage Number of articles per page.
     * @param int|null $page The page number.
     * @param bool $strict Whether to apply strict filtering.
     * @return array The filtered articles.
     */
    public function getArticles(array $filters = [], int $perPage = 10, ?int $page = null, bool $strict = true): array
    {
        $query = $this->articleModel->newQuery();

        $this->applyFilters($query, $filters, $strict);

        return $query->paginate($perPage, ['*'], 'page', $page)->toArray();
    }

    /**
     * Apply filters to the query.
     *
     * @param Builder $query
     * @param array $filters
     * @param bool $strict
     */
    protected function applyFilters(Builder $query, array $filters, bool $strict): void
    {
        if (!empty($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('published_at', [$filters['start_date'], $filters['end_date']]);
        }

        $this->applyFilter($query, 'category', $filters['category'] ?? null, $strict);
        $this->applyFilter($query, 'source', $filters['source'] ?? null, $strict);
        $this->applyFilter($query, 'author', $filters['author'] ?? null, $strict);
    }

    /**
     * Apply a filter to the query.
     *
     * @param Builder $query
     * @param string $field
     * @param mixed $value
     * @param bool $strict
     */
    protected function applyFilter(Builder $query, string $field, mixed $value, bool $strict): void
    {
        if (is_null($value)) {
            return;
        }

        if (is_array($value)) {
            if ($strict) {
                $query->whereIn($field, $value);
            } else {
                $query->orWhere(function ($q) use ($field, $value) {
                    $q->whereIn($field, $value);
                });
            }
        } else {
            if ($strict) {
                $query->where($field, $value);
            } else {
                $query->orWhere($field, $value);
            }
        }
    }

    /**
     * Create a new article.
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        return $this->articleModel->create($data);
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
        $article = $this->getById($id);
        $article->update($data);

        return $article;
    }

    /**
     * Get an article by its ID.
     *
     * @param int $id
     * @return Article|null
     */
    public function getById(int $id): ?Article
    {
        return $this->articleModel->find($id);
    }

    /**
     * Delete an article.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $article = $this->articleModel->findOrFail($id);

        return $article->delete();
    }
}
