<?php

namespace App\Repositories\UserPreference;

use App\Models\UserPreference;

class UserPreferenceRepository implements UserPreferenceRepositoryInterface
{
    /**
     * Get preferences by user ID.
     *
     * @param int $userId
     * @return UserPreference
     */
    public function getByUserId(int $userId): UserPreference
    {
        return UserPreference::where('user_id', $userId)->firstOrFail();
    }

    /**
     * Create or update user preferences.
     *
     * @param int $userId
     * @param array $data
     * @return UserPreference
     */
    public function updateOrCreate(int $userId, array $data): UserPreference
    {
        return UserPreference::updateOrCreate(['user_id' => $userId], $data);
    }
}
