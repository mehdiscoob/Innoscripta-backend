<?php

// app/Console/Commands/FetchArticlesCommand.php

namespace App\Console\Commands;

use App\Services\Fetch\FetchArticleService;
use Illuminate\Console\Command;

/**
 * Class FetchArticlesCommand
 * @package App\Console\Commands
 */
class FetchArticlesCommand extends Command
{
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
     * The article fetching service.
     *
     * @var FetchArticleService
     */
    private FetchArticleService $fetchArticleService;

    /**
     * @param FetchArticleService $fetchArticleService
     */
    public function __construct(FetchArticleService $fetchArticleService)
    {
        $this->fetchArticleService = $fetchArticleService;
        parent::__construct();
    }


    /**
     * This method triggers the fetching of articles from various sources and saves them to the database.
     *
     */
    public function handle()
    {
        $fetch = $this->fetchArticleService->fetch();
        $this->info($fetch);
    }
}
