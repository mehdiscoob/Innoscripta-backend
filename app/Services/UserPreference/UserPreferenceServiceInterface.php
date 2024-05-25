<?php

namespace App\Services\UserPreference;

use App\Models\UserPreference;

interface UserPreferenceServiceInterface
{
    /**
     * Get user preferences by user ID.
     *
     * @param int $userId
     * @return UserPreference
     */
    public function getUserPreferences(int $userId): UserPreference;

    /**
     * Update user preferences.
     *
     * @param int $userId
     * @param array $data
     * @return UserPreference
     */
    public function updateUserPreferences(int $userId, array $data): UserPreference;
}
