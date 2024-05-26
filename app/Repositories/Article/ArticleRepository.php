<?php

namespace  App\Repositories\Article;

use App\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * Get all articles or search based on filters.
     *
     * @param array $filters
     * @return array
     */
    public function getAll(array $filters = []): array
    {
        $query = Article::query();

        if (!empty($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('published_at', [$filters['start_date'], $filters['end_date']]);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        return $query->paginate(20)->toArray();
    }

    /**
     * Get an article by its ID.
     *
     * @param int $id
     * @return Article|null
     */
    public function getById(int $id): ?Article
    {
        return Article::find($id);
    }

    /**
     * Create a new article.
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article
    {
        return Article::create($data);
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
     * Delete an article.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $article = Article::findOrFail($id);

        return $article->delete();
    }
}
