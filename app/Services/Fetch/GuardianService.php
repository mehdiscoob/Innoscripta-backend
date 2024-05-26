<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;
use Illuminate\Support\Facades\Http;

class GuardianService implements FetchArticleStragtegy
{
    public function fetch(ArticleServiceInterface $articleService): bool
    {
        $response = Http::withOptions(['verify' => false])->get(env("GUARDIAN_API_URL"), [
            'api-key' => env('GUARDIAN_API_KEY'),
            'show-fields' => 'all',
            'page-size' => 10,
        ]);

        $articles = $response->json()['response']['results'];

        foreach ($articles as $article) {
            $articleService->create([
                'title' => $article['webTitle'],
                'description' => $article['fields']['trailText'] ?? null,
                'content' => $article['fields']['bodyText'] ?? null,
                'author' => $article['fields']['byline'] ?? null,
                'source' => 'The Guardian',
                'category' => $article['sectionName'],
                'url' => $article['webUrl'],
                'url_to_image' => $article['fields']['thumbnail'] ?? null,
                'published_at' => date('Y-m-d H:i:s',strtotime($article['webPublicationDate'])),
            ]);
        }
        return true;
    }
}
