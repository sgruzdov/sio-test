<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 10:23
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Enum;

/**
 * @package App\Enum
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
enum CouponType: int
{
    case AMOUNT = 1;
    case PERCENT = 2;
}
