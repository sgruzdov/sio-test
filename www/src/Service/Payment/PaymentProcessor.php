<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 14:57
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Payment;

use App\Enum\PaymentProcessorType;
use App\Exception\ServiceNotFoundException;
use App\Service\Payment\Adapter\AdapterLocator;
use App\Service\Payment\Exception\PaymentException;

/**
 * Class PaymentProcessor
 *
 * @package App\Service\Payment
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class PaymentProcessor
{
    private AdapterLocator $adapterLocator;

    /**
     * Constructor PaymentProcessor
     *
     * @param AdapterLocator $adapterLocator
     */
    public function __construct(AdapterLocator $adapterLocator)
    {
        $this->adapterLocator = $adapterLocator;
    }

    /**
     * @param float                $price
     * @param PaymentProcessorType $processorType
     * @return bool
     * @throws ServiceNotFoundException
     */
    public function purchase(float $price, PaymentProcessorType $processorType): bool
    {
        try {
            $this->adapterLocator->getByType($processorType)->purchase($price);
        } catch (PaymentException) {
            return false;
        }

        return true;
    }
}
