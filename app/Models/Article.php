<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="Article",
 *      title="Article",
 *      description="Article model",
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="The unique identifier for the article",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          description="The title of the article",
 *          example="Sample Article"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="The description of the article",
 *          example="This is a sample article description"
 *      ),
 *      @OA\Property(
 *          property="content",
 *          type="string",
 *          description="The content of the article",
 *          example="Lorem ipsum dolor sit amet, consectetur adipiscing elit..."
 *      ),
 *      @OA\Property(
 *          property="author",
 *          type="string",
 *          description="The author of the article",
 *          example="John Doe"
 *      ),
 *      @OA\Property(
 *          property="source",
 *          type="string",
 *          description="The source of the article",
 *          example="New York Times"
 *      ),
 *      @OA\Property(
 *          property="category",
 *          type="string",
 *          description="The category of the article",
 *          example="Technology"
 *      ),
 *      @OA\Property(
 *          property="url",
 *          type="string",
 *          description="The URL of the article",
 *          example="https://example.com/article"
 *      ),
 *      @OA\Property(
 *          property="url_to_image",
 *          type="string",
 *          description="The URL to the image of the article",
 *          example="https://example.com/article/image.jpg"
 *      ),
 *      @OA\Property(
 *          property="published_at",
 *          type="string",
 *          description="The date and time when the article was published",
 *          example="2022-05-10 12:00:00"
 *      ),
 *      @OA\Property(
 *      property="created_at",
 *      type="string",
 *      description="The date and time when the user preference was created",
 *      example="2022-05-10 12:00:00"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          description="The date and time when the user preference was last updated",
 *          example="2022-05-10 12:00:00"
 *      ),
 * )
 */
class Article extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'author',
        'source',
        'category',
        'url',
        'url_to_image',
        'published_at'
    ];

}
