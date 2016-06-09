<?php

namespace App\News\Repositories;

use Illuminate\Contracts\Cache\Repository;
use App\Repositories\BaseRepository;

class CachingVideoRepository extends BaseRepository implements NewsRepository
{
    /**
     * @var NewsRepository
     */
    private $newsRepository;
    /**
     * @var Factory
     */
    private $cache;

    /**
     * NewsRepository constructor.
     * @param DefaultNewsRepository $newsRepository
     * @param Repository $cache
     */
    public function __construct(DefaultNewsRepository $newsRepository, Repository $cache)
    {
        $this->post_type = 'news';
        $this->newsRepository = $newsRepository;
        $this->cache = $cache;
    }

    public function all()
    {
        return $this->cache->remember('news.all', 5, function() {
            return $this->newsRepository->all();
        });
    }
}