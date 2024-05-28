<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;

class FetchArticleService
{
    /**
     * The article service responsible for creating article records.
     *
     * @var ArticleServiceInterface
     */
    private ArticleServiceInterface $articleService;

    /**
     * FetchArticleService constructor.
     *
     * @param ArticleServiceInterface $articleService The article service responsible for creating article records.
     */
    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Fetch articles from multiple sources.
     *
     * This method uses various fetching strategies to retrieve articles from different
     * sources (New York Times, The Guardian, and News API) and stores them using the
     * provided article service.
     *
     * @return string Returns a message indicating the fetching process is done.
     */
    public function fetch(): string
    {
        $NYTime=(new NewYorkTimesService())->fetch($this->articleService);
        $guardian=(new GuardianService())->fetch($this->articleService);
        $newsAPI=(new NewsAPIService())->fetch($this->articleService);
        return "NewYorkTimes:$NYTime, Guardian:$guardian, NewsAPI:$newsAPI";
    }

}
