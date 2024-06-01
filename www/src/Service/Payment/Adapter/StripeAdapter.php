<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 15:12
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Payment\Adapter;

use App\Service\Payment\Exception\PaymentException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

/**
 * Class StripeAdapter
 *
 * @package App\Service\Payment\Adapter
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class StripeAdapter implements PaymentAdapterInterface
{
    /**
     * @param float $price
     * @return void
     * @throws PaymentException
     */
    public function purchase(float $price): void
    {
        $result = (new StripePaymentProcessor())->processPayment($price);

        if (!$result) {
            throw PaymentException::create('Unable to process payment');
        }
    }
}
