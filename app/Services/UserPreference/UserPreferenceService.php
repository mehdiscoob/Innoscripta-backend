<?php

namespace App\Services\UserPreference;

use App\Repositories\UserPreference\UserPreferenceRepositoryInterface;
use App\Models\UserPreference;

class UserPreferenceService implements UserPreferenceServiceInterface
{
    protected UserPreferenceRepositoryInterface $userPreferenceRepository;

    /**
     * Constructor
     *
     * @param UserPreferenceRepositoryInterface $userPreferenceRepository
     */
    public function __construct(UserPreferenceRepositoryInterface $userPreferenceRepository)
    {
        $this->userPreferenceRepository = $userPreferenceRepository;
    }

    /**
     * Get all user preferences.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->userPreferenceRepository->getAll();
    }

    /**
     * Get user preferences by ID.
     *
     * @param int $id
     * @return UserPreference|null
     */
    public function getById(int $id): ?UserPreference
    {
        return $this->userPreferenceRepository->getById($id);
    }

    /**
     * Get user preferences by user ID.
     *
     * @param int $userId
     * @return UserPreference|null
     */
    public function getByUserId(int $userId): ?UserPreference
    {
        return $this->userPreferenceRepository->getByUserId($userId);
    }

    /**
     * Create user preferences.
     *
     * @param array $preferences The user preferences to be stored.
     * @return UserPreference The created UserPreference object.
     */
    public function create(array $preferences): UserPreference
    {
        $encodedPreferences = [];
        foreach ($preferences as $key => $value) {
            $encodedPreferences[$key] = json_encode($value);
        }
        return $this->userPreferenceRepository->create($preferences);
    }

    /**
     * Update user preferences by preference ID.
     *
     * @param int $id The ID of the user preference to be updated.
     * @param array $preferences The new user preferences.
     * @return UserPreference The updated UserPreference object.
     */
    public function updateById(int $id, array $preferences): UserPreference
    {
        $encodedPreferences = [];
        foreach ($preferences as $key => $value) {
            $encodedPreferences[$key] = json_encode($value);
        }
        return $this->userPreferenceRepository->updateById($id, $encodedPreferences);
    }

    /**
     * Update user preferences by user ID.
     *
     * @param int $userId The ID of the user whose preferences are to be updated.
     * @param array $preferences The new user preferences.
     * @return UserPreference The updated UserPreference object.
     */
    public function updateByUserId(int $userId, array $preferences): UserPreference
    {
        $encodedPreferences = [];
        foreach ($preferences as $key => $value) {
            $encodedPreferences[$key] = json_encode($value);
        }
        return $this->userPreferenceRepository->updateByUserId($userId, $encodedPreferences);
    }

    /**
     * Delete user preferences by user ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteByUserId(int $userId): bool
    {
        return $this->userPreferenceRepository->deleteByUserId($userId);
    }

    /**
     * Delete user preferences by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->userPreferenceRepository->deleteById($id);
    }
}
