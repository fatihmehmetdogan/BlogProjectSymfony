<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Validation\AdminLoginValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserSecurityController extends AbstractController
{

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @param AuthService $authService
     * @return Response
     * @Route("/login", name="memberLogin", methods={"POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request, AuthService $authService): Response
    {
        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if($request->getMethod() !== Request::METHOD_POST) {
            return $this->render('security/login.html.twig');
        }

        $all = $request->request->all();
        $validator = new AdminLoginValidator($all);
        $validator->validateForLogin();

        if(!empty($validator->errors)){
            $this->addFlash("errors", $validator->errors);
             return $this->redirectToRoute('memberLoginView');

        }

        $authService->memberLogin($validator->email, $validator->password);
        $request->getSession()->set('_security.last_username', $validator->email);
        return $this->redirect("/");
    }

    /**
     * @Route("/member/login", name="memberLoginView", methods={"GET"})
     * @return Response
     */
    public function memberLoginViewAction()
    {
        return $this->render('security/login.html.twig');
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
