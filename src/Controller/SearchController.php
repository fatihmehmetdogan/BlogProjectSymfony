<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use App\Service\BlogSearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request, BlogSearchService $blogSearchService): Response
    {
        $foundBlogs = $blogSearchService->search($request->request->get('searchParams'));
        return $this->render('blog/index.html.twig', [
            'items' => $foundBlogs,
        ]);
    }
}
