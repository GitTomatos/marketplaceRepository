<?php

namespace App\Module\b2b\style1\Table\Infrastructure\Repository;

use App\Module\b2b\style1\Table\Domain\Entity\Package;
use App\Module\b2b\style1\Table\Domain\Entity\Purchase;
use App\Module\b2b\style1\Table\Domain\RepositoryInterface\PurchaseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository implements PurchaseRepositoryInterface
{
    private string $tableName = 'purchase';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Purchase $entity, bool $flush = true): void
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
    public function remove(Purchase $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findActiveEAPurchases(): ?array
    {
        return $this->findEAPurchases([
            'closeDateTime' => [
                '>',
                (new \DateTime('now'))->format('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function findEAPurchases(array $extraCriteria = []): ?array
    {
        $criteria = [
            'type' => 'electronicAuction',
        ];

        return $this->findPurchases(array_merge($criteria, $extraCriteria));
    }

    public function findPurchases(array $columnsCriteria = []): ?array
    {
        $alias = 'p';
        $preparedConditionsAndParams = $this->prepareWhereConditionsAndParams($columnsCriteria, $alias);
        $preparedConditions = $preparedConditionsAndParams['conditions'];
        $preparedParams = $preparedConditionsAndParams['params'];


        $queryBuilder = $this->createQueryBuilder($alias);

        foreach ($preparedConditions as $i => $preparedCondition) {
            if ($i === 0) {
                $queryBuilder->where($preparedCondition);
            } else {
                $queryBuilder->andWhere($preparedCondition);
            }
        }

        foreach ($preparedParams as $paramName => $paramValue) {
            $queryBuilder->setParameter($paramName, $paramValue);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    private function prepareWhereConditionsAndParams(array $columnsCriteria, string $alias = ''): array
    {
        $availableCompareSigns = ['=', '<', '>', '<>'];
        $whereConditions = [];
        $whereParams = [];

        foreach ($columnsCriteria as $column => $criteria) {
            $comparisonSign = '=';
            $paramName = ':' . $column . 'Value';

            if (is_array($criteria)) {
                if (count($criteria) === 2) {
                    $signFromCriteria = trim($criteria[0]);

                    if (!in_array($signFromCriteria, $availableCompareSigns)) {
                        throw new Exception('Знак для сравнения должен быть одним из следующих: '
                            . implode(',', $availableCompareSigns));
                    }

                    $comparisonSign = $signFromCriteria;

                    $columnValue = trim((string)$criteria[1]);
                } else {
                    throw new Exception('Условия для фильтрации по значениям колонок должны быть вида
                    "[$column1 => $valueToCompare]", либо "[$column1 => [$comparisonSign, $valueToCompare]]"');
                }
            } else {
                $columnValue = trim((string)$criteria);
            }

            $aliasColumn = $alias === ''
                ? $column
                : "$alias.$column";

            $whereConditions[] = "$aliasColumn $comparisonSign $paramName";
            $whereParams[$paramName] = $columnValue;
        }

        return [
            'conditions' => $whereConditions,
            'params' => $whereParams,
        ];
    }

    // /**
    //  * @return Purchase[] Returns an array of Purchase objects
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
    public function findOneBySomeField($value): ?Purchase
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
