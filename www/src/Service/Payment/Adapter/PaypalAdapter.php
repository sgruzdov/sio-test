<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 15:11
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Payment\Adapter;

use App\Service\Payment\Exception\PaymentException;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

/**
 * Class PaypalAdapter
 *
 * @package App\Service\Payment\Adapter
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class PaypalAdapter implements PaymentAdapterInterface
{
    /**
     * @param float $price
     * @return void
     * @throws PaymentException
     */
    public function purchase(float $price): void
    {
        $preparedPrice = to_int(round($price, mode: PHP_ROUND_HALF_DOWN));

        try {
            (new PaypalPaymentProcessor())->pay($preparedPrice);
        } catch (\Throwable $ex) {
            throw PaymentException::create($ex->getMessage());
        }
    }
}
