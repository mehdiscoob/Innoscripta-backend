<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="UserPreference",
 *      title="User Preference",
 *      description="User preference model",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="The unique identifier for the user preference",
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          description="The ID of the user associated with the preference",
 *      ),
 *      @OA\Property(
 *          property="preferred_sources",
 *          type="array",
 *          description="Preferred sources",
 *          @OA\Items(type="string"),
 *      ),
 *      @OA\Property(
 *          property="preferred_categories",
 *          type="array",
 *          description="Preferred categories",
 *          @OA\Items(type="string"),
 *      ),
 *      @OA\Property(
 *          property="preferred_authors",
 *          type="array",
 *          description="Preferred authors",
 *          @OA\Items(type="string"),
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          description="The date and time when the user preference was created",
 *          example="2022-05-10 12:00:00"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          description="The date and time when the user preference was last updated",
 *          example="2022-05-10 12:00:00"
 *      ),
 * )
 */

class UserPreference extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'preferred_sources',
        'preferred_categories',
        'preferred_authors',
    ];

    protected $casts = [
        'preferred_sources' => 'array',
        'preferred_categories' => 'array',
        'preferred_authors' => 'array',
    ];

    /**
     * Get the user that owns the preferences.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
