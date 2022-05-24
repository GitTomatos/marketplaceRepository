<?php

namespace App\Module\b2b\style1\Table\Domain\RepositoryInterface;

use App\Module\b2b\style1\Table\Domain\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface PurchaseRepositoryInterface extends ServiceEntityRepositoryInterface
{
    public function add(Purchase $entity, bool $flush = true): void;

    public function remove(Purchase $entity, bool $flush = true): void;

    public function findActiveEAPurchases(): ?array;

    public function findEAPurchases(array $extraCriteria = []): ?array;

    public function findPurchases(array $columnsCriteria = []): ?array;
}