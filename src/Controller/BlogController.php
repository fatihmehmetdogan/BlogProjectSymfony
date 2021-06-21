<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
    public function detail(Blog $blog) {
        return $this->render('blog/blog_detail.html.twig',[
            'item'=> $blog,
            'comments' => $blog->getComments()->filter(fn($e) => $e->getIsConfirmed())
        ]);
    }

    /**
     * @Route("/blog/{slug}/comment", name="add_comment", methods={"post"})
     * @throws \Doctrine\ORM\ORMException
     */
    public function addComment(Blog $blog, Request $request, EntityManagerInterface $entityManager, Session $session)
    {
        $comment = new Comment();

        $comment->setBlog($blog);
        $comment->setName($request->request->get('name'));
        $comment->setContent($request->request->get('content'));
        $comment->setIsConfirmed(false);

        $entityManager->persist($comment);
        $entityManager->flush();

         $this->addFlash("notice", "Yorumunuz onaylanmak için kaydedildi");
        return $this->redirectToRoute('blog_detail', ["slug" => $blog->getSlug()]);
    }
}
