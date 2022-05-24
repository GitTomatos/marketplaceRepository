<?php

namespace App\Module\b2b\style1\Authorization\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorizationController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {

    }


    #[Route(path: 'b2b/style1/authorization', name: 'render_b2b_style1_authorization')]
    public function authorization(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $login = $request->request->get('login');
            $pass = $request->request->get('pass');

            if ($login !== '' && $pass !== '') {
                $this->requestStack->getSession()->set('isUserLogged', 1);

                return $this->redirect('/b2b/style1/success_login');
            }
        }


        return $this->renderForm(
            'b2b/style1/Authorization/main.twig',
            [
            ]
        );
    }


    #[Route(path: 'b2b/style1/success_login', name: 'render_b2b_style1_success_login')]
    public function successAuthorization(Request $request): Response
    {

        return $this->render(
            'b2b/style1/Authorization/success_login.twig',
            [
            ]
        );
    }

    #[Route(path: 'b2b/style1/logout', name: 'render_b2b_style1_logout')]
    public function logout(): Response
    {
        $this->requestStack->getSession()->set('isUserLogged', 0);
        return $this->redirect('/b2b/style1/preview');
    }
}
