<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;


interface FetchArticleStragtegy
{
    /**
     * Fetch articles from a specific source and store them using the provided article service.
     *
     * Implementing classes should provide the logic to fetch articles from their respective
     * sources and create records in the database. This method should return the number of
     * articles successfully fetched and stored.
     *
     * @param ArticleServiceInterface $articleService The article service responsible for creating article records.
     *
     * @return int Returns the number of articles successfully fetched and stored.
     */
    public function fetch(ArticleServiceInterface $articleService): int;

}
