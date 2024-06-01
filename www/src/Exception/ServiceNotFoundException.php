<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 14:37
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Exception;

/**
 * Class ServiceNotFoundException
 *
 * @package App\Exception
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class ServiceNotFoundException extends \Exception
{
    /**
     * @param string $className
     * @return static
     */
    public static function create(string $className): static
    {
        return new static(sprintf('Service "%s" not found. You must importing service in method "getSubscribedServices".', $className));
    }
}
