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

use App\Entity\Coupon;

/**
 * Class CouponRepository
 *
 * @package App\Repository
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CouponRepository extends AbstractRepository
{
    /**
     * @param string|null $code
     * @return Coupon|null
     */
    public function getEntityByCode(?string $code): ?Coupon
    {
        if ($code === null) {
            return null;
        }

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('e')
            ->from(Coupon::class, 'e')
            ->where($qb->expr()->eq('e.code', ':code'))
            ->andWhere($qb->expr()->eq('e.isUsed', ':isUsed'))
            ->setParameter('code', $code)
            ->setParameter('isUsed', false);

        return $this->getSingleResult($qb);
    }
}
