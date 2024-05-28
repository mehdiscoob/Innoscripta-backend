<?php

namespace App\Http\Controllers\Article;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Services\Article\ArticleServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


class ArticleController extends Controller
{
    protected ArticleServiceInterface $articleService;

    /**
     * Constructor
     *
     * @param ArticleServiceInterface $articleService
     */
    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Get all articles or search based on filters.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['keyword', 'start_date', 'end_date', 'category', 'source']);
            $articles = $this->articleService->getArticles($filters);

            return response()->json(['articles' => $articles]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get an article by its ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $article = $this->articleService->getById($id);

            if ($article) {
                return response()->json(['article' => $article]);
            } else {
                return response()->json(['error' => 'Article not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create a new article.
     *
     * @param  CreateArticleRequest  $request
     * @return JsonResponse
     */
    public function store(CreateArticleRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $article = $this->articleService->create($data);

            return response()->json(['article' => $article], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing article.
     *
     * @param  UpdateArticleRequest  $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateArticleRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->all();
            $article = $this->articleService->update($id, $data);

            return response()->json(['article' => $article]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete an article.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->articleService->delete($id);

            if ($result) {
                return response()->json(['message' => 'Article deleted successfully']);
            } else {
                return response()->json(['error' => 'Article not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get the personalized news feed for the authenticated user.
     *
     * @return JsonResponse
     */
    public function getPersonalizedFeed(): JsonResponse
    {
        try {
            $articles = $this->articleService->getPersonalizedFeed();
            return response()->json(['articles' => $articles]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
