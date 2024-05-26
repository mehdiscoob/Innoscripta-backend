<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;
use Illuminate\Support\Facades\Http;

class NewsAPIService implements FetchArticleStragtegy
{
    public function fetch(ArticleServiceInterface $articleService): bool
    {
        $response = Http::withOptions(['verify' => false])->get(env("NEWS_API_URL"), [
            'apiKey' => env('NEWS_API_KEY'),
            'language' => 'en',
            'pageSize' => 10,
        ]);
        $articles = $response->json()['articles'];
        foreach ($articles as $article) {
            if (isset($article->id)){
                $articleService->create([
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'content' => $article['content'],
                    'author' => $article['author'],
                    'source' => $article['source']['name'],
                    'category' => 'general',
                    'url' => $article['url'],
                    'url_to_image' => $article['urlToImage'],
                    'published_at' => date('Y-m-d H:i:s',strtotime($article['publishedAt'])),
                ]);
            }
        }
        return true;
    }
}
