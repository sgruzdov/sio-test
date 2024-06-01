<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:15
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Enum;

use App\Service\Payment\Adapter\PaymentAdapterInterface;
use App\Service\Payment\Adapter\PaypalAdapter;
use App\Service\Payment\Adapter\StripeAdapter;

/**
 * @package App\Enum
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
enum PaymentProcessorType: int
{
    case PAYPAL = 1;
    case STRIPE = 2;
    case INVALID = 3; // Stub for validation

    /**
     * @return class-string<PaymentAdapterInterface>
     */
    public function getAdapterClassName(): string
    {
        return match ($this) {
            self::PAYPAL  => PaypalAdapter::class,
            self::STRIPE  => StripeAdapter::class,
            self::INVALID => throw new \LogicException('Payment processor is not supported'),
        };
    }

    /**
     * @param string $value
     * @return PaymentProcessorType|null
     */
    public static function tryFromString(string $value): ?PaymentProcessorType
    {
        return match ($value) {
            'paypal' => self::PAYPAL,
            'stripe' => self::STRIPE,
            default  => self::INVALID,
        };
    }
}
