<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 1.06.24
 * Time: 11:32
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Enum\CouponType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CouponFixture
 *
 * @package App\DataFixtures
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CouponFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $coupon = new Coupon();
        $coupon
            ->setCode('HAPPY13')
            ->setType(CouponType::AMOUNT)
            ->setAmount(13);
        $manager->persist($coupon);

        $coupon = new Coupon();
        $coupon
            ->setCode('SIO5')
            ->setType(CouponType::PERCENT)
            ->setAmount(5);
        $manager->persist($coupon);

        $coupon = new Coupon();
        $coupon
            ->setCode('PHP10')
            ->setType(CouponType::AMOUNT)
            ->setAmount(10)
            ->setIsUsed(true);
        $manager->persist($coupon);

        $manager->flush();
    }
}
