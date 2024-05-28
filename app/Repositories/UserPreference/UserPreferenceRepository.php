<?php

namespace App\Repositories\UserPreference;

use App\Models\UserPreference;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserPreferenceRepository implements UserPreferenceRepositoryInterface
{
    /**
     * The UserPreference model instance.
     *
     * @var UserPreference
     */
    protected UserPreference $userPreferenceModel;

    /**
     * UserPreferenceRepository constructor.
     *
     * @param UserPreference $userPreferenceModel
     */
    public function __construct(UserPreference $userPreferenceModel)
    {
        $this->userPreferenceModel = $userPreferenceModel;
    }

    /**
     * Get all user preferences.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->userPreferenceModel->newQuery()->paginate()->toArray();
    }

    /**
     * Create user preferences.
     *
     * @param array $preferences The user preferences to be stored.
     * @return UserPreference The created UserPreference object.
     */
    public function create(array $preferences): UserPreference
    {
        return $this->userPreferenceModel->create($preferences);
    }

    /**
     * Update user preferences by preference ID.
     *
     * @param int $id The ID of the user preference to be updated.
     * @param array $preferences The new user preferences.
     * @return UserPreference The updated UserPreference object.
     * @throws ModelNotFoundException If the user preference with the given ID is not found.
     */
    public function updateById(int $id, array $preferences): UserPreference
    {
        $userPreference = $this->getById($id);
        $userPreference->update($preferences);

        return $userPreference;
    }

    /**
     * Get user preferences by ID.
     *
     * @param int $id
     * @return UserPreference|null
     */
    public function getById(int $id): ?UserPreference
    {
        return $this->userPreferenceModel->findorFail($id);
    }

    /**
     * Update user preferences by user ID.
     *
     * @param int $userId The ID of the user whose preferences are to be updated.
     * @param array $preferences The new user preferences.
     * @return UserPreference The updated UserPreference object.
     * @throws ModelNotFoundException If the user preference for the given user ID is not found.
     */
    public function updateByUserId(int $userId, array $preferences): UserPreference
    {
        $userPreference = $this->getByUserId($userId);
        $userPreference->update($preferences);

        return $userPreference;
    }

    /**
     * Get user preferences by user ID.
     *
     * @param int $userId
     * @return UserPreference|null
     */
    public function getByUserId(int $userId): ?UserPreference
    {
        return $this->userPreferenceModel->where('user_id', $userId)->first();
    }

    /**
     * Delete user preferences by user ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteByUserId(int $userId): bool
    {
        return (bool)$this->userPreferenceModel->where('user_id', $userId)->delete();
    }

    /**
     * Delete user preferences by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return (bool)$this->userPreferenceModel->destroy($id);
    }
}
