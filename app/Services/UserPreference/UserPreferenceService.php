<?php

namespace App\Services\UserPreference;

use App\Repositories\UserPreference\UserPreferenceRepositoryInterface;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

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
     * Get user preferences by Authentication.
     *
     * @return UserPreference|null
     */
    public function getByAuth(): ?UserPreference
    {
        $userId=Auth::id();
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
        return $this->userPreferenceRepository->create($encodedPreferences);
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
     * Update or create user preferences for the authenticated user.
     *
     * This method checks if user preferences already exist for the authenticated user.
     * If they do, it updates the preferences with the provided data. If not, it creates new preferences.
     * The preferences are encoded as JSON before being stored.
     *
     * @param array $preferences The user preferences to be stored or updated. Each preference will be JSON encoded.
     * @return array Returns an array containing the updated or created UserPreference data and HTTP status code.
     */
    public function updateByAuth(array $preferences): array
    {
        $encodedPreferences = [];
        $userId = Auth::id();
        $isPreferenceExist = $this->getByUserId($userId);
        foreach ($preferences as $key => $value) {
            $encodedPreferences[$key] = json_encode($value);
        }
        if (isset($isPreferenceExist)) {
            return ["data"=>$this->userPreferenceRepository->updateByUserId($userId, $encodedPreferences),"code"=>200];
        }
        $preferences["user_id"] = $userId;
        return ["data"=>$this->userPreferenceRepository->create($preferences),"code"=>201];
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
