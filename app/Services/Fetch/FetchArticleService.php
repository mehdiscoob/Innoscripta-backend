<?php

namespace App\Services\Fetch;

use App\Services\User\UserServiceInterface;

class FetchArticleService
{
    public UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function fetch(): string
    {
        (new NewYorkTimesService())->fetch($this->userService);
        (new GuardianService())->fetch($this->userService);
        (new NewsAPIService())->fetch($this->userService);
        return "Fetching is done.";
    }

}
