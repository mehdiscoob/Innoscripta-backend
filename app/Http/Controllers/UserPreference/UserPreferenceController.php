<?php

namespace App\Http\Controllers\UserPreference;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPreference\CreateUserPreferenceRequest;
use App\Http\Requests\UserPreference\UpdateUserPreferenceRequest;
use App\Services\UserPreference\UserPreferenceServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserPreferenceController extends Controller
{
    protected UserPreferenceServiceInterface $userPreferenceService;

    /**
     * Constructor
     *
     * @param UserPreferenceServiceInterface $userPreferenceService
     */
    public function __construct(UserPreferenceServiceInterface $userPreferenceService)
    {
        $this->userPreferenceService = $userPreferenceService;
    }

    /**
     * Get user preferences by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        try {
            $userPreferences = $this->userPreferenceService->getByUserId($userId);
            return response()->json(['user_preferences' => $userPreferences]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/user-preference/auth",
     *      operationId="getUserPreferencesByAuth",
     *      tags={"User Preferences"},
     *      summary="Get user preferences by Authentication",
     *      description="Retrieve user preferences for the authenticated user.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="User preferences retrieved successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user_preferences", ref="#/components/schemas/UserPreference"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User preferences not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="error", type="string"),
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
    public function getByAuth(): JsonResponse
    {
        try {
            $userPreferences = $this->userPreferenceService->getByAuth();
            return response()->json(['user_preferences' => $userPreferences]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get all user preferences.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $userPreferences = $this->userPreferenceService->getAll();

            return response()->json(['user_preferences' => $userPreferences]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $userPreferences = $this->userPreferenceService->getById($id);

            return response()->json(['user_preferences' => $userPreferences]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Create or update user preferences.
     *
     * @param CreateUserPreferenceRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserPreferenceRequest $request): JsonResponse
    {
        try {
            $preferences = $request->all();
            $preferences['preferred_sources'] = json_encode($request->get('preferred_sources'));
            $preferences['preferred_categories'] = json_encode($request->get('preferred_categories'));
            $preferences['preferred_authors'] = json_encode($request->get('preferred_authors'));
            $userPreferences = $this->userPreferenceService->create($preferences);

            return response()->json(['user_preferences' => $userPreferences], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update user preferences by ID.
     *
     * @param UpdateUserPreferenceRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserPreferenceRequest $request, int $id): JsonResponse
    {
        try {
            $preferences = $request->all();
            $preferences['preferred_sources'] = json_encode($request->get('preferred_sources'));
            $preferences['preferred_categories'] = json_encode($request->get('preferred_categories'));
            $preferences['preferred_authors'] = json_encode($request->get('preferred_authors'));
            $userPreferences = $this->userPreferenceService->updateById($id, $preferences);

            return response()->json(['user_preferences' => $userPreferences]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update user preferences by user ID.
     *
     * @param Request $request
     * @param int $userId
     * @return JsonResponse
     */
    public function updateByUserId(Request $request, int $userId): JsonResponse
    {
        try {
            $preferences = $request->all();
            $userPreferences = $this->userPreferenceService->updateByUserId($userId, $preferences);

            return response()->json(['user_preferences' => $userPreferences]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/user-preference/auth",
     *      operationId="updateUserPreferencesByAuth",
     *      tags={"User Preferences"},
     *      summary="Update user preferences by Authentication",
     *      description="Update or create user preferences for the authenticated user.",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="User preferences to be updated or created",
     *          @OA\JsonContent(
     *              required={"preferred_sources", "preferred_categories", "preferred_authors"},
     *              @OA\Property(property="preferred_sources", type="array", @OA\Items(type="string")),
     *              @OA\Property(property="preferred_categories", type="array", @OA\Items(type="string")),
     *              @OA\Property(property="preferred_authors", type="array", @OA\Items(type="string")),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User preferences updated successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user_preferences", ref="#/components/schemas/UserPreference"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User preferences created successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="user_preferences", ref="#/components/schemas/UserPreference"),
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
    public function updateByAuth(Request $request): JsonResponse
    {
        try {
            $preferences = $request->all();
            $userPreferences = $this->userPreferenceService->updateByAuth($preferences);
            return response()->json(['user_preferences' => $userPreferences['data']],$userPreferences['code']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete user preferences by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function deleteByUserId(int $userId): JsonResponse
    {
        try {
            $result = $this->userPreferenceService->deleteByUserId($userId);

            if ($result) {
                return response()->json(['message' => 'User preferences deleted successfully']);
            } else {
                return response()->json(['error' => 'User preferences not found.'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->userPreferenceService->deleteById($id);

            if ($result) {
                return response()->json(['message' => 'User preference deleted successfully']);
            } else {
                return response()->json(['error' => 'User preference not found.'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
