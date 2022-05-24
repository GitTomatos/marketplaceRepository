<?php

namespace App\Module\b2b\style1\Footer\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    #[Route(path: 'b2b/style1/footer', name: 'render_b2b_style1_footer')]
    public function footer(): Response
    {
        return $this->renderForm(
            'b2b/style1/Footer/main.twig',
            [
            ]
        );
    }
}
