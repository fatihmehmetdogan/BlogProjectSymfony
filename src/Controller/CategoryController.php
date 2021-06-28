<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Category;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Category::class);
        $categories = $repository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }
    /**
     * @Route("/category/{slug}", name="category_index")
     */
    public function category($slug){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository((Category::class));
        /** @var Category $category */
        $category = $repository->findOneBy(['slug'=>$slug]);
        if(!$category){
            throw new NotFoundHttpException();
        }
        /** @var BlogRepository $blogRepository */
        $blogRepository = $em->getRepository(Blog::class);
        $blogs = $blogRepository->findByCategory($category);
        return $this->render('category/category.html.twig',[
            'category'=>$category,
            'blogs' => $blogs
        ]);
    }
}