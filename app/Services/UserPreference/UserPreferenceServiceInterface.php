<?php

namespace App\Services\UserPreference;

use App\Models\UserPreference;

interface UserPreferenceServiceInterface
{
    /**
     * Get all user preferences.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Get user preferences by ID.
     *
     * @param int $id
     * @return UserPreference|null
     */
    public function getById(int $id): ?UserPreference;

    /**
     * Get user preferences by user ID.
     *
     * @param int $userId
     * @return UserPreference|null
     */
    public function getByUserId(int $userId): ?UserPreference;

    /**
     * Get user preferences by Authentication.
     *
     * @return UserPreference|null
     */
    public function getByAuth(): ?UserPreference;

    /**
     * Create user preferences.
     *
     * @param array $preferences The user preferences to be stored.
     * @return UserPreference The created UserPreference object.
     */
    public function create(array $preferences): UserPreference;

    /**
     * Update user preferences by preference ID.
     *
     * @param int $id The ID of the user preference to be updated.
     * @param array $preferences The new user preferences.
     * @return UserPreference The updated UserPreference object.
     */
    public function updateById(int $id, array $preferences): UserPreference;

    /**
     * Update user preferences by user ID.
     *
     * @param int $userId The ID of the user whose preferences are to be updated.
     * @param array $preferences The new user preferences.
     * @return UserPreference The updated UserPreference object.
     */
    public function updateByUserId(int $userId, array $preferences): UserPreference;

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
    public function updateByAuth(array $preferences): array;

    /**
     * Delete user preferences by user ID.
     *
     * @param int $userId
     * @return bool
     */
    public function deleteByUserId(int $userId): bool;

    /**
     * Delete user preferences by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
