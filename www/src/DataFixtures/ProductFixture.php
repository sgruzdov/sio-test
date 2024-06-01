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

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ProductFixture
 *
 * @package App\DataFixtures
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class ProductFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product
            ->setLabel('Iphone')
            ->setPrice(100);
        $manager->persist($product);

        $product = new Product();
        $product
            ->setLabel('Наушники')
            ->setPrice(20);
        $manager->persist($product);

        $product = new Product();
        $product
            ->setLabel('Чехол')
            ->setPrice(10);
        $manager->persist($product);

        $product = new Product();
        $product
            ->setLabel('Часы')
            ->setPrice(50)
            ->setIsActive(false);
        $manager->persist($product);

        $manager->flush();
    }
}
