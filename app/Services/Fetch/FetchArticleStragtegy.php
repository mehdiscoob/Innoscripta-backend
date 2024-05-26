<?php

namespace App\Services\Fetch;

use App\Services\Article\ArticleServiceInterface;

interface FetchArticleStragtegy
{
    public function fetch(ArticleServiceInterface $articleService): bool;

}
