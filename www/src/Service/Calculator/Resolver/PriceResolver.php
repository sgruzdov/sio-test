<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:06
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Calculator\Resolver;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\Country;
use App\Enum\CouponType;
use App\Service\Calculator\DTO\CalculationDTO;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PriceResolver
 *
 * @package App\Service\Calculator\Resolver
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class PriceResolver
{
    private EntityManagerInterface $entityManager;

    /**
     * Constructor PriceResolver
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param CalculationDTO $calculation
     * @return float
     */
    public function resolve(CalculationDTO $calculation): float
    {
        $price = 0;

        $this->applyProductPrice($calculation, $price);
        $this->applyDiscountPrice($calculation, $price);
        $this->applyTaxPrice($calculation, $price);

        return round($price, 2);
    }

    /**
     * @param CalculationDTO $calculation
     * @param float          $price
     * @return void
     */
    private function applyProductPrice(CalculationDTO $calculation, float &$price): void
    {
        $product = $this->entityManager->getRepository(Product::class)->getEntityById(to_int($calculation->getProduct()));

        $price += $product?->getPrice() ?? 0;
    }

    /**
     * @param CalculationDTO $calculation
     * @param float          $price
     * @return void
     */
    private function applyDiscountPrice(CalculationDTO $calculation, float &$price): void
    {
        $coupon = $this->entityManager->getRepository(Coupon::class)->getEntityByCode(try_to_string($calculation->getCoupon()));

        if ($coupon === null) {
            return;
        }

        switch ($coupon->getType()) {
            case CouponType::AMOUNT:

                $price -= $coupon->getAmount();

                break;
            case CouponType::PERCENT:

                $valueTmp = $price * ($coupon->getAmount() / 100);
                $price -= $valueTmp;

                break;
            default:
                // do nothing
        }

        if ($price < 0) {
            $price = 0.0;
        }
    }

    /**
     * @param CalculationDTO $calculation
     * @param float          $price
     * @return void
     */
    private function applyTaxPrice(CalculationDTO $calculation, float &$price): void
    {
        $country = Country::tryFromTaxNumber(to_string($calculation->getTaxNumber()));

        if ($country === null) {
            return;
        }

        $valueTmp = $price * ($country->getTaxPercent() / 100);
        $price += $valueTmp;
    }
}
