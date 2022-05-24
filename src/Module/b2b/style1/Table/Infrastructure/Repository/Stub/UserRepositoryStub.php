<?php

namespace App\Module\b2b\style1\Table\Infrastructure\Repository\Stub;

use App\Module\b2b\style1\Table\Domain\Entity\User;
use App\Module\b2b\style1\Table\Infrastructure\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepositoryStub extends UserRepository
{
    public function find($id, $lockMode = null, $lockVersion = null): ?User
    {
        $testUsers = $this->getData()[$id];

        return (new User($id))
            ->setName($testUsers['name'])
            ->setOrganization($testUsers['organization']);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    private function getData(): array
    {
        return [
            1 => [
                'name' => 'Пользователь 1',
                'organization' => 'Его организация',
            ],
        ];
    }
}
