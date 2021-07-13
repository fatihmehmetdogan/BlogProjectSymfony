<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Validation\AdminRegisterValidator;
use MongoDB\Driver\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/admin.login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/admin/register", name="register")
     */
    public function register(Request $request, AuthService $authService, SessionInterface $session): Response
    {
        if($request->getMethod() !== Request::METHOD_POST) {
            return $this->render('registration/admin.register.html.twig');
        }
        $all = $request->request->all();
        $validator = new AdminRegisterValidator($all);
        $validator->validateForm();
        if(!empty($validator->errors)){
            $this->addFlash("errors", $validator->errors);
            return $this->redirectToRoute('register');
        }
        $authService->signUp($all);
        return $this->redirectToRoute("app_login");
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
