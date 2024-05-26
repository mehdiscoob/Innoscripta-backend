<?php

// app/Console/Commands/FetchArticles.php

namespace App\Console\Commands;

use App\Services\Article\ArticleService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * Class FetchArticles
 * @package App\Console\Commands
 */
class FetchArticles extends Command
{
    private ArticleService $articleService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from various news sources and save to the database';

    /**
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return string
     */
    public function handle(): string
    {
        $this->fetchNewsAPIArticles();
        $this->fetchGuardianArticles();
        $this->fetchNYTimesArticles();
        return "OK";
    }

    /**
     * Fetch articles from News API and save to the database.
     */
    protected function fetchNewsAPIArticles()
    {
        $response = Http::withOptions(['verify' => false])->get(env("NEWS_API_URL"), [
            'apiKey' => env('NEWS_API_KEY'),
            'language' => 'en',
            'pageSize' => 10,
        ]);
        $articles = $response->json()['articles'];
        foreach ($articles as $article) {
            if (isset($article->id)){
                $this->articleService->create([
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
    }

    /**
     * Fetch articles from The Guardian API and save to the database.
     */
    protected function fetchGuardianArticles()
    {
        $response = Http::withOptions(['verify' => false])->get(env("GUARDIAN_API_URL"), [
            'api-key' => env('GUARDIAN_API_KEY'),
            'show-fields' => 'all',
            'page-size' => 10,
        ]);

        $articles = $response->json()['response']['results'];

        foreach ($articles as $article) {
            $this->articleService->create([
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
    }

    /**
     * Fetch articles from The New York Times API and save to the database.
     */
    protected function fetchNYTimesArticles()
    {
        $response = Http::withOptions(['verify' => false])->get(env("NYTIMES_API_URL"), [
            'api-key' => env('NYTIMES_API_KEY'),
        ]);
        $articles = $response->json()['results'];

        foreach ($articles as $article) {
            $this->articleService->create([
                'title' => $article['title'],
                'description' => $article['abstract'],
                'content' => $article['abstract'],
                'author' => $article['byline'],
                'source' => 'The New York Times',
                'category' => $article['section'],
                'url' => $article['url'],
                'url_to_image' => $article['multimedia'][0]['url'] ?? null,
                'published_at' => date('Y-m-d H:i:s',strtotime($article['published_date'])),
            ]);
        }
    }
}
