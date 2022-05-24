<?php

namespace App\Module\b2b\style1\Table\Domain\RepositoryInterface;

use App\Module\b2b\style1\Table\Domain\Entity\Package;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface PackageRepositoryInterface extends ServiceEntityRepositoryInterface
{
    public function add(Package $entity, bool $flush = true): void;

    public function remove(Package $entity, bool $flush = true): void;

    public function findByPurchaseAndUser(int $purchaseId, int $userId);

    public function findPackagesToProcessByType(string $type): ?array;
}