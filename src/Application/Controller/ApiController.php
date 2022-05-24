<?php

namespace App\Application\Controller;

use App\Infrastructure\TemplatesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    public function __construct(private TemplatesManager $templater)
    {
    }

    /**
     * Принимает полное название модуля через тире (например, b2b-style1)
     */
    #[Route('/get_module_template_names/{sentModuleName}', name: 'get_module_template_names')]
    public function index(string $sentModuleName): JsonResponse
    {
        $templateModules = $this->templater->getModulesTemplatesList();

        $moduleNameParts = explode('-', $sentModuleName);
        if (count($moduleNameParts) !== 2) {
            return new JsonResponse([]);
        }

        [$eCommerceType, $moduleName] = $moduleNameParts;
        $templateNames = $templateModules[$eCommerceType][$moduleName] ?? [];

        return new JsonResponse($templateNames);
    }
}
