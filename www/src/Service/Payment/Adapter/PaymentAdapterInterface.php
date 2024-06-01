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

/**
 * Interface PaymentAdapterInterface
 *
 * @package App\Service\Payment\Adapter
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
interface PaymentAdapterInterface
{
    /**
     * @param float $price
     * @return void
     * @throws PaymentException
     */
    public function purchase(float $price): void;
}
