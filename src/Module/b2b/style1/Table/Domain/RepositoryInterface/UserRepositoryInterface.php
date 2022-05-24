<?php

namespace App\Module\b2b\style1\Table\Domain\RepositoryInterface;

use App\Module\b2b\style1\Table\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface UserRepositoryInterface extends ServiceEntityRepositoryInterface
{
    public function add(User $entity, bool $flush = true): void;

    public function remove(User $entity, bool $flush = true): void;
}