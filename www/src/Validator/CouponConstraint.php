<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:46
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class CouponConstraint
 *
 * @package App\Validator
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CouponConstraint extends Constraint
{
}
