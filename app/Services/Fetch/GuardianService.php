<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;
use Illuminate\Support\Facades\Http;

class GuardianService implements FetchArticleStragtegy
{
    /**
     * Fetch articles from The Guardian API and store them using the provided article service.
     *
     * This method sends a GET request to The Guardian API, retrieves a list of articles,
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
            $response = Http::withOptions(['verify' => false])->get(env("GUARDIAN_API_URL"), [
                'api-key' => env('GUARDIAN_API_KEY'),
                'show-fields' => 'all',
                'page-size' => 10,
            ]);

            $articles = $response->json()['response']['results'];

            foreach ($articles as $article) {
                try {
                    $articleService->create([
                        'title' => $article['webTitle'],
                        'description' => $article['fields']['trailText'] ?? null,
                        'content' => $article['fields']['bodyText'] ?? null,
                        'author' => $article['fields']['byline'] ?? null,
                        'source' => 'The Guardian',
                        'category' => $article['sectionName'],
                        'url' => $article['webUrl'],
                        'url_to_image' => $article['fields']['thumbnail'] ?? null,
                        'published_at' => date('Y-m-d H:i:s', strtotime($article['webPublicationDate'])),
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
