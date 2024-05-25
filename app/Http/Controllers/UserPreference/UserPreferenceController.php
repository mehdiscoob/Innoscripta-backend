<?php

namespace App\Http\Controllers\UserPreference;

use App\Http\Controllers\Controller;
use App\Services\UserPreference\UserPreferenceServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPreferenceController extends Controller
{
    protected UserPreferenceServiceInterface $userPreferenceService;

    /**
     * UserPreferenceController constructor.
     *
     * @param UserPreferenceServiceInterface $userPreferenceService
     */
    public function __construct(UserPreferenceServiceInterface $userPreferenceService)
    {
        $this->userPreferenceService = $userPreferenceService;
    }

    /**
     * Get the preferences of the authenticated user.
     *
     * @return JsonResponse
     */
    public function getUserPreferences(): JsonResponse
    {
        $preferences = $this->userPreferenceService->getUserPreferences(Auth::id());

        return response()->json($preferences);
    }

    /**
     * Update the preferences of the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUserPreferences(Request $request): JsonResponse
    {
        $data = $request->only(['preferred_sources', 'preferred_categories', 'preferred_authors']);
        $preferences = $this->userPreferenceService->updateUserPreferences(Auth::id(), $data);

        return response()->json($preferences);
    }
}
