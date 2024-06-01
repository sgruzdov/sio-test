<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 09:29
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AbstractRepository
 *
 * @package App\Repository
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
abstract class AbstractRepository extends ServiceEntityRepository implements RepositoryInterface
{
    /**
     * Constructor AbstractRepository
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClassName());
    }

    /**
     * @return EntityInterface
     */
    public function getFreshEntity(): EntityInterface
    {
        return new ($this->getEntityName())();
    }

    /**
     * @param QueryBuilder $qb
     * @return array
     */
    protected function getResult(QueryBuilder $qb): array
    {
        try {
            $result = $qb->getQuery()->getResult();
        } catch (\Throwable) {
            $result = [];
        }

        return $result;
    }

    /**
     * @param QueryBuilder $qb
     * @param mixed|null   $fallbackValue
     * @return mixed
     */
    protected function getSingleResult(QueryBuilder $qb, mixed $fallbackValue = null): mixed
    {
        try {
            $result = $qb->getQuery()->getSingleResult();
        } catch (\Throwable) {
            $result = $fallbackValue;
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        preg_match('/(?<entity>\w+)Repository$/', static::class, $matches);

        $entityClassName = 'App\Entity\\' . $matches['entity'] ?? null;

        if (!class_exists($entityClassName)) {
            throw new \LogicException(sprintf('Incorrect entity or repository name. Repository name: %s', static::class));
        }

        return $entityClassName;
    }
}
