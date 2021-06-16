<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Blog::class);
        $items = $repository->findAll();

        return $this->render('blog/index.html.twig', [
        'items' => $items,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_detail")
     */
    public function detail($slug){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository((Blog::class));
        $item = $repository->findOneBy(['slug'=>$slug]);
        if(!$item){
        }
        return $this->render('blog/blog_detail.html.twig',[
            'item'=>$item,
        ]);
    }
}
