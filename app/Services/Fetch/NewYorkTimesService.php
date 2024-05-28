<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;
use Illuminate\Support\Facades\Http;

class NewYorkTimesService implements FetchArticleStragtegy
{
    /**
     * Fetch articles from The New York Times API and store them using the provided article service.
     *
     * This method sends a GET request to The New York Times API, retrieves a list of articles,
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
            $response = Http::withOptions(['verify' => false])->get(env("NYTIMES_API_URL"), [
                'api-key' => env('NYTIMES_API_KEY'),
            ]);
            $articles = $response->json()['results'];
            foreach ($articles as $article) {
                try {
                    $articleService->create([
                        'title' => $article['title'],
                        'description' => $article['abstract'],
                        'content' => $article['abstract'],
                        'author' => $article['byline'],
                        'source' => 'The New York Times',
                        'category' => $article['section'],
                        'url' => $article['url'],
                        'url_to_image' => $article['multimedia'][0]['url'] ?? null,
                        'published_at' => date('Y-m-d H:i:s', strtotime($article['published_date'])),
                    ]);
                    ++$count;
                } catch
                (\Throwable $exception) {
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
