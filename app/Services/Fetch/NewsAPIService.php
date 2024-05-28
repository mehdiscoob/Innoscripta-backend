<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;
use Illuminate\Support\Facades\Http;

class NewsAPIService implements FetchArticleStragtegy
{
    /**
     * Fetch articles from the News API and store them using the provided article service.
     *
     * This method sends a GET request to the News API, retrieves a list of articles,
     * and iterates through each article to create a record in the database. If an error
     * occurs during the fetch or article creation, it will be caught and logged.
     *
     * @param ArticleServiceInterface $articleService The article service responsible for creating article records.
     *
     * @return int Returns the number of articles successfully fetched and stored.
     */
    public function fetch(ArticleServiceInterface $articleService): int
    {
        $count = 0;
        try {
            $response = Http::withOptions(['verify' => false])->get(env("NEWS_API_URL"), [
                'apiKey' => env('NEWS_API_KEY'),
                'language' => 'en',
                'pageSize' => 10,
            ]);
            $articles = $response->json()['articles'];
            foreach ($articles as $article) {
                try {
                    $articleService->create([
                        'title' => $article['title'],
                        'description' => $article['description'],
                        'content' => $article['content'],
                        'author' => $article['author'],
                        'source' => $article['source']['name'],
                        'category' => 'general',
                        'url' => $article['url'],
                        'url_to_image' => $article['urlToImage'],
                        'published_at' => date('Y-m-d H:i:s', strtotime($article['publishedAt'])),
                    ]);
                    ++$count;
                } catch (\Throwable $exception) {
                    dump($exception->getMessage());
                    continue;
                }

            }
        } catch (\Throwable $exception) {
            dump($exception->getMessage());
        }
        return $count;
    }
}
