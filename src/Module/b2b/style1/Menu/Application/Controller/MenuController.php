<?php

namespace App\Module\b2b\style1\Menu\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    public function __construct(private RequestStack $requestStack)
    {

    }

    #[Route(path: 'b2b/style1/menu', name: 'render_b2b_style1_menu')]
    public function menu(): Response
    {
        $isUserLogged = $this->requestStack->getSession()->get('isUserLogged');

        return $this->renderForm(
            'b2b/style1/Menu/main.twig',
            [
                'isUserLogged' => $isUserLogged === 1,
            ]
        );
    }
}
