<?php

namespace App\Http\Controllers\Article;

use App\Services\Article\ArticleServiceInterface;
use App\Services\UserPreference\UserPreferenceServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class ArticleController extends Controller
{
    protected ArticleServiceInterface $articleService;
    protected UserPreferenceServiceInterface $userPreferenceService;

    /**
     * ArticleController constructor.
     *
     * @param ArticleServiceInterface $articleService
     * @param UserPreferenceServiceInterface $userPreferenceService
     */
    public function __construct(
        ArticleServiceInterface        $articleService,
        UserPreferenceServiceInterface $userPreferenceService
    )
    {
        $this->articleService = $articleService;
        $this->userPreferenceService = $userPreferenceService;
    }

    /**
     * Display a listing of the articles.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['keyword', 'category', 'source']);

        $preferences = $this->userPreferenceService->getUserPreferences(Auth::id());

        if ($preferences) {
            if (!empty($preferences->preferred_sources)) {
                $filters['source'] = $preferences->preferred_sources;
            }
            if (!empty($preferences->preferred_categories)) {
                $filters['category'] = $preferences->preferred_categories;
            }
            if (!empty($preferences->preferred_authors)) {
                $filters['author'] = $preferences->preferred_authors;
            }
        }


        $articles = $this->articleService->getAllArticles($filters);

        return response()->json($articles);
    }

    /**
     * Display the specified article.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $article = $this->articleService->findArticleById($id);

        return response()->json($article);
    }
}
