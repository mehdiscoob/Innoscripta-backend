<?php

namespace App\Services\Article;


use App\Models\Article;
use App\Repositories\Article\ArticleRepositoryInterface;
use App\Services\UserPreference\UserPreferenceServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleService implements ArticleServiceInterface
{
    /**
     * The article repository instance.
     *
     * @var ArticleRepositoryInterface
     */
    protected ArticleRepositoryInterface $articleRepository;

    /**
     * The user preference service instance.
     *
     * @var UserPreferenceServiceInterface
     */
    protected UserPreferenceServiceInterface $userPreferenceService;

    /**
     * ArticleService constructor.
     *
     * @param ArticleRepositoryInterface $articleRepository
     * @param UserPreferenceServiceInterface $userPreferenceService
     */
    public function __construct(ArticleRepositoryInterface $articleRepository, UserPreferenceServiceInterface $userPreferenceService)
    {
        $this->articleRepository = $articleRepository;
        $this->userPreferenceService = $userPreferenceService;
    }

    /**
     * Get all articles or search based on filters.
     *
     * @param array $filters
     * @param int $perPage
     * @param int|null $page
     * @param bool $strict
     * @return array
     */
    public function getArticles(array $filters = [], int $perPage = 10, ?int $page = null, bool $strict = true): array
    {
        return $this->articleRepository->getArticles($filters, $perPage, $page, $strict);
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

    /**
     * Get a personalized news feed for the authenticated user based on preferences.
     *
     * @return array
     * @throws ModelNotFoundException
     */
    public function getPersonalizedFeed(): array
    {
        $filters = [];
        $userId = auth()->id();
        $userPreferences = $this->userPreferenceService->getByUserId($userId);
        if (!$userPreferences) {
            throw new ModelNotFoundException('User preferences not found.');
        }
        $preferredSources = $userPreferences->preferred_sources ?? [];
        $preferredCategories = $userPreferences->preferred_categories ?? [];
        $preferredAuthors = $userPreferences->preferred_authors ?? [];

        if (empty($preferredSources) && empty($preferredCategories) && empty($preferredAuthors)) {
            throw new ModelNotFoundException('User preferences are empty.');
        }

        $filters['source'] = $preferredSources;
        $filters['category'] = $preferredCategories;
        $filters['author'] = $preferredAuthors;

        return $this->articleRepository->getArticles($filters,strict: false);
    }
}
