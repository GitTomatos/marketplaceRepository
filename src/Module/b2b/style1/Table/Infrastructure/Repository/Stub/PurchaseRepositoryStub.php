<?php

namespace App\Module\b2b\style1\Table\Infrastructure\Repository\Stub;

use App\Module\b2b\style1\Table\Domain\Entity\Purchase;
use App\Module\b2b\style1\Table\Infrastructure\Repository\PurchaseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class PurchaseRepositoryStub extends PurchaseRepository
{
    private string $tableName = 'purchase';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }


    public function find($id, $lockMode = null, $lockVersion = null): Purchase|null
    {
        $testPurchases = $this->getTestPurchases();
        foreach ($testPurchases as $purchase) {
            if ($purchase['id'] === $id) {
                return (new Purchase($purchase['id']))
                    ->setType($purchase['type'])
                    ->setInfo($purchase['info'])
                    ->setName($purchase['name'])
                    ->setMaxPrice($purchase['maxPrice'])
                    ->setCloseDateTime($purchase['closeDateTime'])
                    ->setOrganizer($purchase['organizerId']);
            }
        }

        return null;
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


    private function getTestPurchases(): array
    {
        return [
            [
                'id' => 1,
                'type' => 'electronicAuction',
                'info' => 'test1',
                'name' => 'test1',
                'maxPrice' => 1,
                'closeDateTime' => '2025-04-26 16:12:12',
                'organizerId' => 1,
            ],
            [
                'id' => 4,
                'type' => 'electronicAuction',
                'info' => 'Инфо 1',
                'name' => 'Эл аукцион 1',
                'maxPrice' => '700000',
                'closeDateTime' => '2022-04-20 10:30:00',
                'organizerId' => 1,
            ],
            [
                'id' => 5,
                'type' => 'electronicAuction',
                'info' => 'Инфо 1',
                'name' => 'Эл аукцион 2',
                'maxPrice' => '30000',
                'closeDateTime' => '2022-04-25 13:00:00',
                'organizerId' => 1,
            ],
            [
                'id' => 6,
                'type' => 'electronicAuction',
                'info' => 'Инфо 3',
                'name' => 'Эл аукцион 3',
                'maxPrice' => '150000',
                'closeDateTime' => '2022-04-15 10:30:00',
                'organizerId' => 1,
            ],
        ];
    }
}
