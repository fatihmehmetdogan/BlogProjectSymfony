<?php

namespace App\Controller;

use App\Service\AuthService;
use App\Validation\AdminLoginValidator;
use App\Validation\AdminRegisterValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function login(AuthenticationUtils $authenticationUtils, Request $request, AuthService $authService): Response
    {
//        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
//        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if($request->getMethod() !== Request::METHOD_POST) {
            return $this->render('security/admin.login.html.twig');
        }
        $all = $request->request->all();
        $validator = new AdminLoginValidator($all);
        $validator->validateForLogin();

        if(!empty($validator->errors)){
            $this->addFlash("errors", $validator->errors);
            return $this->redirectToRoute('app_login');

        }

        $authService->login($validator->email,$validator->password);
        $request->getSession()->set('_security.last_username', $validator->email);
        return $this->redirect("/admin/dashboard");



//        return $this->render('security/admin.login.html.twig');
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
        $authService->signUp($validator->email, $validator->password, $validator->confirmPassword);
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
