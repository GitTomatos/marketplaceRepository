<?php

namespace App\Module\b2b\style1\Table\Infrastructure\Repository\Stub;

use App\Module\b2b\style1\Table\Domain\Entity\Package;
use App\Module\b2b\style1\Table\Infrastructure\Repository\PackageRepository;
use App\Module\b2b\style1\Table\Infrastructure\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

class PackageRepositoryStub extends PackageRepository
{
    public function __construct(
        private UserRepository $userRepository,
        ManagerRegistry $registry,
    )
    {
        parent::__construct($registry, Package::class);
    }

    public function findByPurchaseAndUser(int $purchaseId, int $userId): ?Package
    {
        $testPackages = $this->getTestPackages();

        foreach ($testPackages as $package) {
            if ($package['id'] === $purchaseId && $package['userId'] === $userId) {
                $user = $this->userRepository->find($package['id']);
                if ($user === null) {
                    break;
                }

                return (new Package($package['id']))
                    ->setUser($user)
                    ->setName($package['name'])
                    ->setInfo($package['info'])
                    ->setState($package['state'])
                    ->setPrice($package['price'])
                    ->setPurchaseId($package['purchaseId']);
            }
        }

        return null;
    }

    public function findPackagesToProcessByType(string $type): ?array
    {
        return $this->createQueryBuilder('package')
            ->join(
                'package.purchaseId',
                'purchase',
                JOIN::WITH,
                'package.purchaseId = purchase.id'
            )->where("purchase.type = :type")
            ->andWhere("package.state = :state")
            ->setParameters(new ArrayCollection([
                new Parameter('type', $type),
                new Parameter('state', Package::inProcessing),
            ]))
            ->getQuery()
            ->getResult();
    }


    private function getTestPackages(): array
    {
        return [
            [
                'id' => 20,
                'userId' => 1,
                'name' => 'Пакет с ценой 2',
                'info' => 'Информация',
                'state' => 'Обработано',
                'price' => 124144,
                'purchaseId' => 4,
            ],
        ];
    }
}
