<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;
use Illuminate\Support\Facades\Http;

class NewYorkTimesService implements FetchArticleStragtegy
{
    public function fetch(ArticleServiceInterface $articleService): bool
    {
        $response = Http::withOptions(['verify' => false])->get(env("NYTIMES_API_URL"), [
            'api-key' => env('NYTIMES_API_KEY'),
        ]);
        $articles = $response->json()['results'];

            foreach ($articles as $article) {
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
            }
            return true;
    }
}
