<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 09:51
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;

/**
 * Class ProductRepository
 *
 * @package App\Repository
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class ProductRepository extends AbstractRepository
{
    /**
     * @param int $id
     * @return Product|null
     */
    public function getEntityById(int $id): ?Product
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('e')
            ->from(Product::class, 'e')
            ->where($qb->expr()->eq('e.id', ':id'))
            ->andWhere($qb->expr()->eq('e.isActive', ':isActive'))
            ->setParameter('id', $id)
            ->setParameter('isActive', true);

        return $this->getSingleResult($qb);
    }
}
