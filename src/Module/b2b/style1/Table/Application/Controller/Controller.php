<?php

namespace App\Module\b2b\style1\Table\Application\Controller;

use App\Module\b2b\style1\Table\Domain\Entity\Package;
use App\Module\b2b\style1\Table\Domain\Entity\User;
use App\Module\b2b\style1\Table\Form\Type\PackageCreationType;
use App\Module\b2b\style1\Table\Form\Type\ProcessPackageType;
use App\Module\b2b\style1\Table\Infrastructure\Repository\PackageRepository;
use App\Module\b2b\style1\Table\Infrastructure\Repository\PurchaseRepository;
use App\Module\b2b\style1\Table\Infrastructure\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    private ObjectManager $entityManager;
    private User $currentUser;

    public function __construct(
        private UserRepository $userRepository,
        private PackageRepository $packageRepository,
        private PurchaseRepository $purchaseRepository,
        ManagerRegistry $doctrine
    ) {
        $this->entityManager = $doctrine->getManager();
        $this->currentUser = $this->userRepository->find(1);
    }


    #[Route(path: 'b2b/style1/table', name: 'render_table')]
    public function table(): Response
    {
        return $this->renderForm(
            'b2b/style1/Table/main.twig',
            [
            ]
        );
    }

    #[Route('/procedure_info', name: 'b2b_procedure_info')]
    public function procedureInfo(): Response
    {
        return $this->renderForm(
            'b2b/style1/Table/procedure_info.twig',
            [
            ]
        );
    }

    #[Route('/forms', name: 'forms')]
    public function forms(Request $request): Response
    {
        $package = (new Package())->setUser($this->currentUser);
        $packageForm = $this->createForm(PackageCreationType::class, $package);
        $packageProcessForm = $this->createForm(ProcessPackageType::class);

        $packageForm->handleRequest($request);
        if ($packageForm->isSubmitted() && $packageForm->isValid()) {
            /** @var Package $newPackage */
            $newPackage = $packageForm->getData();
            $this->entityManager->persist($newPackage);
            $this->entityManager->flush();

            return new Response("Package added!");
        }

        $packageProcessForm->handleRequest($request);
        if ($packageProcessForm->isSubmitted() && $packageProcessForm->isValid()) {
            /** @var Package $packageToProcess */
            $packageToProcess = $packageProcessForm->getData()['electronicAuctionPackages'];
            $packageToProcess->setState(Package::processed);
            $this->entityManager->flush();
        }

        return $this->renderForm(
            'b2b/style1/forms.twig',
            [
                'packageForm' => $packageForm,
                'packageProcessForm' => $packageProcessForm,
            ],
        );
    }

    #[Route('/b2b/style1/table/procedure_info/{purchaseId}', name: 'preview-b2b-style1-table-procedure_info')]
    public function procedureInfoPreview(int $purchaseId): Response
    {
        $isRequested = (bool)$this->packageRepository->findByPurchaseAndUser(
            $purchaseId,
            $this->currentUser->getId()
        );

        return $this->renderForm(
            'b2b/style1/Table/procedure_info.twig',
            [
                'isRequested' => $isRequested,
            ],
        );
    }

    #[Route('/preview/request/{purchaseId}', name: 'request')]
    public function submit(
        Request $request,
        int $purchaseId,
    ): Response {
        $purchase = $this->purchaseRepository->find($purchaseId);

        if ($purchase === null) {
            return new Response("Нет такого пакета!");
        }

        $newPackage = (new Package())
            ->setName('test1')
            ->setInfo('test1')
            ->setUser($this->currentUser)
            ->setPrice(1)
            ->setPurchaseId($purchase);

        $this->entityManager->persist($newPackage);
        $this->entityManager->flush();

        return $this->redirectToRoute(
            'preview-b2b-style1-table-procedure_info',
            ['purchaseId' => $purchaseId]
        );
//        $packageProcessForm->handleRequest($request);
//        if ($packageProcessForm->isSubmitted() && $packageProcessForm->isValid()) {
//            /** @var Package $packageToProcess */
//            $packageToProcess = $packageProcessForm->getData()['electronicAuctionPackages'];
//            $packageToProcess->setState(Package::processed);
//            $this->entityManager->flush();
//        }
//
//        return $this->renderForm(
//            'b2b/style1/forms.twig',
//            [
//                'packageForm' => $packageForm,
//                'packageProcessForm' => $packageProcessForm,
//            ],
//        );
    }
}
