<?php

namespace App\Module\b2b\style1\Preview\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Preview extends AbstractController
{
    #[Route(path: 'b2b/style1/preview', name: 'render_b2b_style1_all')]
    public function menu(): Response
    {
        return $this->renderForm(
            'b2b/style1/Preview/main.twig',
            [
            ]
        );
    }
}
