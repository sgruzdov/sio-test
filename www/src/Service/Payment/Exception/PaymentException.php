<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 14:57
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Payment\Exception;

/**
 * Class PaymentException
 *
 * @package App\Service\Payment\Exception
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class PaymentException extends \Exception
{
    /**
     * @param string $message
     * @return static
     */
    public static function create(string $message): static
    {
        return new static($message);
    }
}
