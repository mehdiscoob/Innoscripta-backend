<?php

namespace App\Http\Controllers\Article;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Services\Article\ArticleServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * @OA\Tag(
 *     name="Articles",
 *     description="Endpoints for managing articles"
 * )
 */
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
     * @OA\Get(
     *      path="/api/articles",
     *      operationId="getArticles",
     *      tags={"Articles"},
     *      summary="Get all articles or search based on filters",
     *      @OA\Parameter(
     *          name="keyword",
     *          in="query",
     *          description="Keyword to search for articles",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="start_date",
     *          in="query",
     *          description="Start date for filtering articles",
     *          required=false,
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="end_date",
     *          in="query",
     *          description="End date for filtering articles",
     *          required=false,
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="category",
     *          in="query",
     *          description="Category to filter articles",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="source",
     *          in="query",
     *          description="Source to filter articles",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of articles",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="articles", type="array", @OA\Items(ref="#/components/schemas/Article")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="error", type="string"),
     *          ),
     *      ),
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['keyword', 'start_date', 'end_date', 'category', 'source']);
            $articles = $this->articleService->getArticles($filters);

            return response()->json(['articles' => $articles]);
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/articles/personalized-feed",
     *      operationId="getPersonalizedFeed",
     *      tags={"Articles"},
     *      summary="Get the personalized news feed for the authenticated user",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Personalized news feed",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="articles", type="array", @OA\Items(ref="#/components/schemas/Article")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="error", type="string"),
     *          ),
     *      ),
     * )
     */
    public function getPersonalizedFeed(): JsonResponse
    {
        try {
            $articles = $this->articleService->getPersonalizedFeed();
            return response()->json(['articles' => $articles]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
