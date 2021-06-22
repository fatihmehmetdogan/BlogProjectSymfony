<?php


namespace App\Service;


use App\Repository\BlogRepository;

/**
 * Class BlogSearchService
 * @package App\Service
 */
class BlogSearchService
{
    /**
     * @var BlogRepository
     */
    protected $blogRepository;

    /**
     * BlogSearchService constructor.
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param $searchParams
     * @return \App\Entity\Blog[]
     */
    public function search($searchParams)
    {
        return $this->blogRepository->findByTitleOrContentField($searchParams);
    }
}