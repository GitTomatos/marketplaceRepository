<?php

namespace App\Module\b2b\style1\Table\Domain\RepositoryInterface;

use App\Module\b2b\style1\Table\Domain\Entity\Organization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface OrganizationRepositoryInterface extends ServiceEntityRepositoryInterface
{
    public function add(Organization $entity, bool $flush = true): void;

    public function remove(Organization $entity, bool $flush = true): void;

}