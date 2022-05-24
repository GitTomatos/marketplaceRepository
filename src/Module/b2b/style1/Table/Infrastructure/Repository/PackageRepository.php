<?php

namespace App\Module\b2b\style1\Table\Infrastructure\Repository;

use App\Module\b2b\style1\Table\Domain\Entity\Package;
use App\Module\b2b\style1\Table\Domain\RepositoryInterface\PackageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Package|null find($id, $lockMode = null, $lockVersion = null)
 * @method Package|null findOneBy(array $criteria, array $orderBy = null)
 * @method Package[]    findAll()
 * @method Package[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageRepository extends ServiceEntityRepository implements PackageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Package::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Package $entity, bool $flush = true): void
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
    public function remove(Package $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByPurchaseAndUser(int $purchaseId, int $userId)
    {
        $packages = $this->createQueryBuilder('package')
            ->where("package.purchaseId = :purchaseId")
            ->andWhere("package.user = :userId")
            ->setParameter('purchaseId', $purchaseId)
            ->setParameter('userId', $userId)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $packages ? $packages[0] : null;
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

    // /**
    //  * @return Package[] Returns an array of Package objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Package
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
