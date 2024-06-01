<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:47
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class ProductConstraint
 *
 * @package App\Validator
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class ProductConstraint extends Constraint
{
}
