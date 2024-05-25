<?php

namespace App\Repositories\UserPreference;

use App\Models\UserPreference;

interface UserPreferenceRepositoryInterface
{
    /**
     * Get preferences by user ID.
     *
     * @param int $userId
     * @return UserPreference
     */
    public function getByUserId(int $userId): UserPreference;

    /**
     * Create or update user preferences.
     *
     * @param int $userId
     * @param array $data
     * @return UserPreference
     */
    public function updateOrCreate(int $userId, array $data): UserPreference;
}
