<?php

namespace App\Module\b2c\style1\Menu\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{

    #[Route(path: 'b2c/style1/menu', name: 'render_menu')]
    public function items(): Response
    {
        return $this->renderForm(
            'b2c/style1/Menu/main.twig',
            [
            ]
        );
    }
}
