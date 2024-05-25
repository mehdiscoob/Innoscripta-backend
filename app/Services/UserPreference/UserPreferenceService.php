<?php

namespace App\Services\UserPreference;

use App\Models\UserPreference;
use App\Repositories\UserPreference\UserPreferenceRepositoryInterface;

class UserPreferenceService implements UserPreferenceServiceInterface
{
    protected UserPreferenceRepositoryInterface $userPreferenceRepository;

    public function __construct(UserPreferenceRepositoryInterface $userPreferenceRepository)
    {
        $this->userPreferenceRepository = $userPreferenceRepository;
    }

    /**
     * Get user preferences by user ID.
     *
     * @param int $userId
     * @return UserPreference
     */
    public function getUserPreferences(int $userId): UserPreference
    {
        return $this->userPreferenceRepository->getByUserId($userId);
    }

    /**
     * Update user preferences.
     *
     * @param int $userId
     * @param array $data
     * @return UserPreference
     */
    public function updateUserPreferences(int $userId, array $data): UserPreference
    {
        return $this->userPreferenceRepository->updateOrCreate($userId, $data);
    }
}
