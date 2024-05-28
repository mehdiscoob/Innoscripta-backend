<?php

namespace App\Http\Controllers\UserPreference;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPreference\CreateUserPreferenceRequest;
use App\Http\Requests\UserPreference\UpdateUserPreferenceRequest;
use App\Services\UserPreference\UserPreferenceServiceInterface;
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
    public function getUserById(int $userId): JsonResponse
    {
        try {
            $userPreferences = $this->userPreferenceService->getByUserId($userId);
            return response()->json(['user_preferences' => $userPreferences]);
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
