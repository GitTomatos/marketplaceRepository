<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Infrastructure\TemplatesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PreviewController extends AbstractController
{
    public function __construct(private TemplatesManager $templater)
    {
    }

    #[Route('/preview', name: 'previewAllTemplates')]
    public function previewAllTemplates(): Response
    {
        $templateList = $this->templater->getModulesTemplatesList();

        return $this->renderForm(
            'previewAll.twig',
            [
                'templateList' => $templateList,
            ],
        );
    }
}